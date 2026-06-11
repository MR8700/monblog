<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LigdiCashService
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $apiToken;

    public function __construct()
    {
        $this->baseUrl = config('services.ligdicash.base_url', 'https://app.ligdicash.com');
        $this->apiKey = config('services.ligdicash.api_key');
        $this->apiToken = config('services.ligdicash.api_token');
    }

    /**
     * Crée une facture de redirection (Checkout Invoice Redirect)
     */
    public function createInvoice(Order $order)
    {
        $payload = [
            'commande' => [
                'invoice' => [
                    'items' => $this->formatOrderItems($order),
                    'total_amount' => (int) $order->total_price,
                    'devise' => 'XOF',
                    'description' => 'Paiement de la commande #' . $order->id,
                    'customer' => $order->user_email,
                    'customer_firstname' => $order->user_name,
                    'customer_lastname' => '',
                    'external_id' => (string) $order->id,
                    'otp' => ''
                ],
                'store' => [
                    'name' => config('app.name'),
                    'website_url' => config('app.url')
                ],
                'actions' => [
                    'cancel_url' => route('payments.ligdicash.cancel', ['order' => $order->id]),
                    'return_url' => route('payments.ligdicash.success', ['order' => $order->id]),
                    'callback_url' => config('services.ligdicash.callback_url')
                ],
                'custom_data' => [
                    'order_id' => $order->id
                ]
            ]
        ];

        Log::info('LigdiCash: Creating invoice for Order #' . $order->id, ['payload' => $payload]);

        $response = Http::withHeaders($this->getHeaders())
            ->post($this->baseUrl . '/pay/v01/redirect/checkout-invoice/create', $payload);

        if ($response->successful()) {
            $data = $response->json();
            Log::info('LigdiCash: Invoice created successfully', ['response' => $data]);
            return $data;
        }

        Log::error('LigdiCash: Failed to create invoice', [
            'order_id' => $order->id,
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        return null;
    }

    /**
     * Confirme un paiement via le token reçu dans le callback
     */
    public function confirmPayment(string $token)
    {
        $response = Http::withHeaders($this->getHeaders())
            ->get($this->baseUrl . "/pay/v01/redirect/checkout-invoice/confirm/?token={$token}");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('LigdiCash: Payment confirmation failed', [
            'token' => $token,
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        return null;
    }

    /**
     * Vérifie le statut d'une transaction via son ID
     */
    public function getTransactionStatus(string $transactionId)
    {
        // LigdiCash API might have an endpoint for this, usually it's used if polling is needed.
        // For now, we rely on callback + confirm.
    }

    protected function getHeaders(): array
    {
        return [
            'Apikey' => $this->apiKey,
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function formatOrderItems(Order $order): array
    {
        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                'name' => $item->product ? $item->product->name : ($item->post ? $item->post->title : 'Article'),
                'description' => '',
                'quantity' => (int) $item->quantity,
                'unit_price' => (int) $item->price,
                'total_amount' => (int) ($item->quantity * $item->price)
            ];
        }
        return $items;
    }
}
