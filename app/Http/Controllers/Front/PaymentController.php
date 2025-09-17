<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function processManualPayment(Request $request, PaymentService $paymentService)
    {
        $latestInvoice = Invoice::latest()->first();

        $invoiceNumber = $latestInvoice ? str(str($latestInvoice->invoice_id)->chopStart('IV-')->toInteger() + 1)->padLeft(5, '0') : '00001';

        $invoice = Invoice::create([
            'invoice_id' => 'IV-'.$invoiceNumber,
            'full_name' => $request->string('fullname'),
            'amount' => $request->price,
            'price' => $request->price,
            'trip_name' => $request->string('trip_name'),
            'email' => $request->string('email'),
            'contact_number' => $request->string('contact_number'),
            'ref_id' => $invoiceNumber,
        ]);

        $data['invoiceNo'] = $invoice->ref_id;
        $data['description'] = str($request->trip_name)->limit(47);
        $data['type'] = 'manual';

        $paymentUrl = $paymentService->processPayment($invoice->price, $data);

        return redirect($paymentUrl);
    }

    public function successCallback(Request $request)
    {
        if (! $request->ref_id) {
            abort(403);
        }
        $invoice = Invoice::where('ref_id', $request->ref_id)->firstOrFail();
        $invoice->status = Invoice::PAID;
        $invoice->save();

        if ($request->source === 'manual') {
            return to_route('hbl.manualPayment.success')->with('status', 'success');
        }

        return to_route('hbl.payment.success')->with('status', 'success');

    }

    public function paymentSuccess(Request $request)
    {
        if (session('status') !== 'success') {
            abort(403);
        }

        return view('front.trips.booking-thanks');
    }

    public function manualPaymentSuccess(Request $request)
    {
        if (session('status') !== 'success') {
            abort(403);
        }

        return view('front.trips.booking-thanks');
    }

    public function paymentCanceled(Request $request)
    {
        $invoice = Invoice::where('ref_id', $request->orderNo)->first();
        $invoice->status = Invoice::CANCELED;
        $invoice->save();

        return to_route('home')->with('error_message', 'Payment canceled. Please try again.');
    }

    public function paymentFailed(Request $request)
    {
        $invoice = Invoice::where('ref_id', $request->orderNo)->first();
        $invoice->status = Invoice::FAILED;
        $invoice->save();

        return to_route('home')->with('error_message', 'Payment failed. Please try again.');
    }
}
