<?php

namespace App\Services\Payment;

use App\Models\Order;

class OrangeMoneyProvider implements PaymentProviderInterface
{
    public function initiatePayment(Order $order): array
    {
        // Simulation d'appel API Orange Money
        return [
            'status' => 'pending',
            'message' => 'Veuillez saisir le code OTP reçu sur votre téléphone.',
            'transaction_id' => 'OM-' . uniqid(),
        ];
    }

    public function processPayment(Order $order, array $data): bool
    {
        // Simulation de vérification OTP
        // Dans un cas réel, on appellerait l'API Orange Money avec l'OTP
        if (isset($data['otp']) && strlen($data['otp']) >= 4) {
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
