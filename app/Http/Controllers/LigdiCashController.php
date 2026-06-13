<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmed;
use App\Models\Order;
use App\Services\Payment\LigdiCashService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LigdiCashController extends Controller
{
    protected LigdiCashService $ligdiCashService;

    public function __construct(LigdiCashService $ligdiCashService)
    {
        $this->ligdiCashService = $ligdiCashService;
    }

    public function initiate(Order $order)
    {
        if ($order->payment_status === Order::STATUS_PAID) {
            return redirect()
                ->route('orders.confirmation', ['order' => $order->publicRouteParameter()])
                ->with('info', 'Cette commande est deja payee.');
        }

        $invoice = $this->ligdiCashService->createInvoice($order);

        if (!$invoice || !isset($invoice['response_text'], $invoice['token'])) {
            Log::warning('LigdiCash invoice rejected: missing redirect URL or token', ['order_id' => $order->id]);

            return back()->with('error', 'Impossible d initier le paiement avec LigdiCash. Veuillez reessayer.');
        }

        $order->update([
            'payment_method' => 'ligdicash',
            'payment_status' => Order::STATUS_PENDING,
            'ligdicash_token_hash' => hash('sha256', $invoice['token']),
        ]);

        return redirect()->away($invoice['response_text']);
    }

    public function callback(Request $request)
    {
        // Debug only in local or for critical troubleshooting
        if (config('app.debug')) {
            Log::info('LigdiCash callback received', [
                'ip' => $request->ip(),
                'has_token' => $request->filled('token'),
            ]);
        }

        $token = $request->input('token');
        $orderToken = $request->input('custom_data.order_token') ?? $request->input('external_id');

        if (!is_string($token) || !is_string($orderToken)) {
            Log::warning('LigdiCash callback rejected: missing token or order reference');

            return response()->json(['status' => 'error', 'message' => 'Missing data'], 400);
        }

        $order = Order::where('public_token', $orderToken)->first();

        if (!$order) {
            Log::warning('LigdiCash callback rejected: order not found', [
                'order_token_hash' => hash('sha256', $orderToken),
            ]);

            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        if (!$order->ligdicash_token_hash || !hash_equals($order->ligdicash_token_hash, hash('sha256', $token))) {
            Log::warning('LigdiCash callback rejected: token mismatch', ['order_id' => $order->id]);

            return response()->json(['status' => 'error', 'message' => 'Invalid token'], 403);
        }

        if ($order->payment_status === Order::STATUS_PAID) {
            return response()->json(['status' => 'success', 'message' => 'Already processed']);
        }

        $confirmation = $this->ligdiCashService->confirmPayment($token);

        if ($confirmation && ($confirmation['response_code'] ?? null) === '00') {
            if (isset($confirmation['amount']) && (int) $confirmation['amount'] !== (int) $order->total_price) {
                Log::error('LigdiCash amount mismatch', [
                    'order_id' => $order->id,
                    'expected' => $order->total_price,
                    'received' => $confirmation['amount'],
                ]);

                return response()->json(['status' => 'error', 'message' => 'Amount mismatch'], 400);
            }

            $processed = DB::transaction(function () use ($order): bool {
                $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();

                if ($lockedOrder->payment_status === Order::STATUS_PAID) {
                    return false;
                }

                $lockedOrder->update([
                    'payment_status' => Order::STATUS_PAID,
                    'payment_processed_at' => now(),
                    'status' => 'processing',
                ]);

                return true;
            });

            Log::info('LigdiCash payment accepted', ['order_id' => $order->id, 'processed' => $processed]);

            if ($processed) {
                try {
                    Mail::to($order->user_email)->send(new OrderConfirmed($order->fresh(['items.product', 'items.post'])));
                } catch (\Throwable $exception) {
                    Log::error('LigdiCash confirmation email failed', [
                        'order_id' => $order->id,
                        'error' => $exception->getMessage(),
                    ]);
                }
            }

            return response()->json(['status' => 'success']);
        }

        Log::warning('LigdiCash payment confirmation rejected', [
            'order_id' => $order->id,
            'response_code' => $confirmation['response_code'] ?? null,
        ]);

        if ($order->payment_status !== Order::STATUS_PAID) {
            $order->update(['payment_status' => Order::STATUS_FAILED]);
        }

        return response()->json(['status' => 'failed']);
    }

    public function success(Order $order)
    {
        return view('payments.ligdicash.processing', compact('order'));
    }

    public function cancel(Order $order)
    {
        return redirect()
            ->route('orders.payment.select', ['order' => $order->publicRouteParameter()])
            ->with('warning', 'Le paiement a ete annule.');
    }

    public function checkStatus(Order $order)
    {
        return response()->json([
            'status' => $order->payment_status,
            'redirect_url' => route('orders.confirmation', ['order' => $order->publicRouteParameter()]),
        ]);
    }
}
