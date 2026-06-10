<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Payment\LigdiCashService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LigdiCashController extends Controller
{
    protected LigdiCashService $ligdiCashService;

    public function __construct(LigdiCashService $ligdiCashService)
    {
        $this->ligdiCashService = $ligdiCashService;
    }

    /**
     * Initie le paiement LigdiCash
     */
    public function initiate(Order $order)
    {
        if ($order->payment_status === Order::STATUS_PAID) {
            return redirect()->route('orders.confirmation', $order)->with('info', 'Cette commande est déjà payée.');
        }

        $invoice = $this->ligdiCashService->createInvoice($order);

        if (!$invoice || !isset($invoice['response_text'])) {
            return back()->with('error', 'Impossible d\'initier le paiement avec LigdiCash. Veuillez réessayer.');
        }

        // On stocke le token si besoin (souvent présent dans response_text ou autre part)
        // Pour LigdiCash Redirect, response_text contient l'URL de redirection
        
        $order->update([
            'payment_method' => 'ligdicash',
            'payment_status' => Order::STATUS_PENDING,
            'payment_reference' => $invoice['token'] ?? null
        ]);

        return redirect()->away($invoice['response_text']);
    }

    /**
     * Webhook (Callback) de LigdiCash
     */
    public function callback(Request $request)
    {
        Log::info('LigdiCash Callback received', $request->all());

        $token = $request->input('token');
        $orderId = $request->input('custom_data.order_id') ?? $request->input('external_id');

        if (!$token || !$orderId) {
            Log::error('LigdiCash Callback: Missing token or order_id');
            return response()->json(['status' => 'error', 'message' => 'Missing data'], 400);
        }

        $order = Order::find($orderId);

        if (!$order) {
            Log::error('LigdiCash Callback: Order not found', ['order_id' => $orderId]);
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        // Éviter le double traitement
        if ($order->payment_status === Order::STATUS_PAID) {
            return response()->json(['status' => 'success', 'message' => 'Already processed']);
        }

        // Confirmer le paiement auprès de LigdiCash
        $confirmation = $this->ligdiCashService->confirmPayment($token);

        if ($confirmation && isset($confirmation['response_code']) && $confirmation['response_code'] === '00') {
            // Vérification de sécurité optionnelle : vérifier le montant si disponible dans la réponse
            if (isset($confirmation['amount']) && (int)$confirmation['amount'] !== (int)$order->total_price) {
                Log::error('LigdiCash: Amount mismatch', [
                    'order_id' => $order->id,
                    'expected' => $order->total_price,
                    'received' => $confirmation['amount']
                ]);
                return response()->json(['status' => 'error', 'message' => 'Amount mismatch'], 400);
            }

            $order->update([
                'payment_status' => Order::STATUS_PAID,
                'status' => 'processing'
            ]);

            Log::info('LigdiCash: Order #' . $order->id . ' marked as PAID');
            
            // Envoyer l'email de confirmation
            try {
                \Illuminate\Support\Facades\Mail::to($order->user_email)->send(new \App\Mail\OrderConfirmed($order));
            } catch (\Exception $e) {
                Log::error("LigdiCash: Error sending confirmation email : " . $e->getMessage());
            }

            return response()->json(['status' => 'success']);
        }

        Log::warning('LigdiCash: Payment confirmation failed or rejected', ['order_id' => $order->id, 'response' => $confirmation]);
        
        $order->update(['payment_status' => Order::STATUS_FAILED]);

        return response()->json(['status' => 'failed']);
    }

    /**
     * Retour après succès (UI)
     */
    public function success(Order $order)
    {
        return view('payments.ligdicash.processing', compact('order'));
    }

    /**
     * Retour après annulation (UI)
     */
    public function cancel(Order $order)
    {
        return redirect()->route('orders.payment.select', $order)
            ->with('warning', 'Le paiement a été annulé.');
    }

    /**
     * Endpoint pour le polling JS afin de vérifier si le paiement est passé
     */
    public function checkStatus(Order $order)
    {
        return response()->json([
            'status' => $order->payment_status,
            'redirect_url' => route('orders.confirmation', $order)
        ]);
    }
}
