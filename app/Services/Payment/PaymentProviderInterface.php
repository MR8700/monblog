<?php

namespace App\Services\Payment;

use App\Models\Order;

interface PaymentProviderInterface
{
    /**
     * Initiate the payment process.
     */
    public function initiatePayment(Order $order): array;

    /**
     * Process the payment with provided data (e.g., OTP).
     */
    public function processPayment(Order $order, array $data): bool;

    /**
     * Verify the payment status.
     */
    public function verifyPayment(Order $order): bool;
}
