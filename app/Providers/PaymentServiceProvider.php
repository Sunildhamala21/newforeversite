<?php

namespace App\Providers;

use App\Services\Hbl\HblPaymentGateway;
use App\Services\PaymentGatewayInterface;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentGatewayInterface::class, HblPaymentGateway::class);
    }

    public function boot(): void {}
}
