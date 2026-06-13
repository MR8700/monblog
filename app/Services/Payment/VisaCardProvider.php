<?php

namespace App\Services\Payment;

use App\Models\Order;

class VisaCardProvider implements PaymentProviderInterface
{
    public function initiatePayment(Order $order): array
    {
        return [
            'status' => 'redirect',
            'redirect_url' => route('orders.payment.visa', ['order' => $order->publicRouteParameter()]),
            'transaction_id' => 'VISA-' . uniqid(),
        ];
    }

    public function processPayment(Order $order, array $data): bool
    {
        // Simulation de traitement par carte Visa
        if (isset($data['card_number']) && strlen($data['card_number']) >= 16) {
            $order->update([
                'payment_status' => Order::STATUS_PAID,
                'payment_reference' => $data['transaction_id'] ?? $order->payment_reference,
                'status' => 'confirmed'
            ]);
            return true;
        }

        $order->update(['payment_status' => Order::STATUS_FAILED]);
        return false;
    }

    public function verifyPayment(Order $order): bool
    {
        return $order->payment_status === Order::STATUS_PAID;
    }
}
