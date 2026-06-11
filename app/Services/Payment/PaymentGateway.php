<?php

namespace App\Services\Payment;

use App\Models\Order;
use Exception;

class PaymentGateway
{
    protected $providers = [
        'orange_money' => OrangeMoneyProvider::class,
        'visa' => VisaCardProvider::class,
    ];

    public function getProvider(string $method): PaymentProviderInterface
    {
        if (!isset($this->providers[$method])) {
            throw new Exception("Méthode de paiement non supportée : {$method}");
        }

        return new $this->providers[$method]();
    }
}
