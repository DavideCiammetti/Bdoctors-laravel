<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Sponsorship;
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
        //variabili
        $user = Auth::user();
        $sponsorships = Sponsorship::all();

        $clientToken = $this->gateway->clientToken()->generate();
        return view('admin.doctors.payment', compact('user', 'clientToken', 'sponsorships'));
    }

    public function processPayment(Request $request)
    {

        //variabili
        $user = Auth::user();
        $doctor = $user->doctor;
        $sponsorship = json_decode($request->sponsorships, true);
        //fine sponsorizzazione
        $endDate = now(config("app.timezone"))->addHours($sponsorship['duration']);
        // @dd($endDate);
        // Get nonce from the payment form
        $nonce = $request->input('payment_method_nonce');



        // Create a transaction
        $result = $this->gateway->transaction()->sale([
            'amount' => $sponsorship['price'], // replace with the actual amount
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);



        if ($result->success) {

            //pagamento ok quindi assegno al dottore la sponsorizzazione
            $doctor->sponsorships()->sync([
                $sponsorship['id'] => ['end_date' => $endDate],
            ]);

            return redirect()->route('admin.doctor.payment')->with('success_message', 'Payment successful!');
        } else {
            // Payment failed
            $errorMessages = $result->message;

            return redirect()->route('admin.doctor.payment')->with('error_message', $errorMessages);
        }
    }
}
