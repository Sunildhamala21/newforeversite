<?php

namespace App\Services;

interface PaymentGatewayInterface
{
    public function charge(float $amount, array $data, string $currency);
}
