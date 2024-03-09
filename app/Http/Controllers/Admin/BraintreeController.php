<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Braintree\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BraintreeController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        // Initialize Braintree gateway with your credentials - collegato a services.php
        $this->gateway = new Gateway([
            'environment' => config('services.braintree.env'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key')
        ]);
    }

    public function checkout()
    {
        $user = Auth::user();

        $clientToken = $this->gateway->clientToken()->generate();
        return view('admin.doctors.payment', compact('user', 'clientToken'));
    }

    public function processPayment(Request $request)
    {
        // Get nonce from the payment form
        $nonce = $request->input('payment_method_nonce');

        // Create a transaction
        $result = $this->gateway->transaction()->sale([
            'amount' => $request->amount, // replace with the actual amount
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);



        if ($result->success) {
            // Payment was successful



            return redirect()->route('admin.doctor.payment')->with('success_message', 'Payment successful!');
        } else {
            // Payment failed
            $errorMessages = $result->message;

            return redirect()->route('admin.doctor.payment')->with('error_message', $errorMessages);
        }
    }
}
