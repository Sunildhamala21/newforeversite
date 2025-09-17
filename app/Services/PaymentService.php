<?php

namespace App\Services;

class PaymentService
{
    protected PaymentGatewayInterface $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function processPayment(float $amount, array $data, string $currency = 'USD')
    {
        return $this->paymentGateway->charge($amount, $data, $currency);
    }
}
