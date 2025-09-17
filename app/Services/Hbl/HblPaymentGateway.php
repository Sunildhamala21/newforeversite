<?php

namespace App\Services\Hbl;

use App\Services\Hbl\Api\Payment;
use App\Services\PaymentGatewayInterface;
use Illuminate\Http\RedirectResponse;

class HblPaymentGateway implements PaymentGatewayInterface
{
    public function charge(float $amount, array $data, string $currency = 'USD'): string
    {
        $payment = new Payment();

        $merchant_id = config('hbl.OfficeId');
        $api_key = config('hbl.AccessToken');
        $input_currency = config('hbl.InputCurrency');
        $input_amount = $amount; // maybe price
        $input_3d = config('hbl.Input3DS');

        $joseResponse =  $payment->ExecuteFormJose(
            mid: $merchant_id,
            api_key: $api_key,
            curr: $input_currency,
            amt: $input_amount,
            threeD: $input_3d,
            success_url: route('hbl.payment.success') . '?ref_id=' . $data['invoiceNo'],
            failed_url: route('hbl.payment.failed'),
            cancel_url: route('hbl.payment.canceled'),
            backend_url: route('home'),
            data: $data,
        );

        $response_obj = json_decode($joseResponse);

        return $response_obj->response->Data->paymentPage->paymentPageURL;
    }
}
