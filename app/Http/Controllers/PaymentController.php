<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class PaymentController extends Controller

{

    public  function index(){
        return  view('checkout');
    }

    public function checkout(PaymentRequest $request)
    {
        $validated = $request->validated();
        $tranId = (string)Str::uuid();
        $payment = Payment::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'transaction_id' => $tranId,
            'amount' => 100,
            'currency' => 'BDT',
            'status' => 'pending',
        ]);
        $paymentData = [
            'store_id' => config('services.sslcommerz.store_id'),
            'store_passwd' =>config('services.sslcommerz.store_password'),
            'total_amount' => 100,
            'currency' => 'BDT',
            'tran_id' => $tranId,

            'cus_name' => $validated['name'],
            'cus_email' => $validated['email'],
            'cus_add1' => 'Doctor Para',
            'cus_city' => 'Feni',
            'cus_country' => 'Bangladesh',
            'cus_phone' => $validated['phone'],

            'shipping_method' => 'NO',
            'product_name' => 'Test Product',
            'product_category' => 'General',
            'product_profile' => 'general',

            'success_url' => route('payment.success'),
            'fail_url' => route('payment.fail'),
            'cancel_url' => route('payment.cancel'),
        ];

        $response = Http::asForm()->post('https://sandbox.sslcommerz.com/gwprocess/v4/api.php',$paymentData);
        return redirect()->away($response['GatewayPageURL']);
    }

    public function success(Request $request)
    {
        $tranId = $request->input('tran_id');
        $valId = $request->input('val_id');

        if(!$tranId || !$valId){
            return response('Missing transaction information.', 400);
        }

        $payment = Payment::where('transaction_id', $tranId)->first();
        if(!$payment){
            return response('Payment not found.', 404);
        }

        if($payment->status === 'paid'){
            return  "Payment already verified";
        }

        $response = Http::get(
            'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php',
            [
                'val_id' => $valId,
                'store_id' =>config('services.sslcommerz.store_id'),
                'store_passwd' =>config('services.sslcommerz.store_password'),
                'format'=> 'json',
            ]
        );

        if(!$response->successful()){
            return response('Could not verify payment', 502);
        }

        $data = $response->json();

        $validStatus = in_array(
            $data['status'] ?? '',
            ['VALID','VALIDATED'],
            true
        );

        $sameTransaction = ($data['tran_id'] ?? '')  === $payment->transaction_id;
        $sameCurrency = ($data['currency'] ?? '') === $payment->currency;
        $sameAmount = isset($data['amount']) && (float) $data['amount'] === (float) $payment->amount;

        if(!$sameTransaction || !$sameCurrency ||  !$sameAmount){
            return response('Payment verification failed.', 422);
        }

        $payment->update(['status' => 'paid']);
        return  "Payment successfully verified";

    }




}
