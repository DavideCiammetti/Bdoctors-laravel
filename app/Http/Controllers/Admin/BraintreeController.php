<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Sponsorship;
use Braintree\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BraintreeController extends Controller
{
    /**
     * Inizializzo la variabile  gateway per tutta la classe
     */
    protected $gateway;

    /**
     * Construct della classe, creo il mio Braintree\Gateway 
     */
    public function __construct()
    {
        // Inizzializzo un Gateway per Braintree - collegato a services.php
        $this->gateway = new Gateway([
            'environment' => config('services.braintree.env'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key')
        ]);
    }

    /**
     * Chiama la view di pagamento a cui passo lo user, le sponsorizzazioni e il clientToken per Braintree
     */
    public function checkout()
    {
        //variabili
        $user = Auth::user();
        $sponsorships = Sponsorship::all();

        $clientToken = $this->gateway->clientToken()->generate();
        return view('admin.doctors.payment', compact('user', 'clientToken', 'sponsorships'));
    }

    /**
     * Chiamato al pagamento, verifica la transazione e assegan al dottore la spoinsorizzione  
     */
    public function processPayment(Request $request)
    {

        //variabili
        $user = Auth::user();
        $doctor = $user->doctor;
        $sponsorship = json_decode($request->sponsorships, true);

        //fine sponsorizzazione
        if ($sponsorship['duration'] === '24:00:00') {
            $endDate = now(config("app.timezone"))->addHours(24);
        }
        if ($sponsorship['duration'] === '72:00:00') {
            $endDate = now(config("app.timezone"))->addHours(72);
        }
        if ($sponsorship['duration'] === '144:00:00') {
            $endDate = now(config("app.timezone"))->addHours(144);
        }


        // Inizializzo il nonce preso da form
        $nonce = $request->input('payment_method_nonce');

        // Creo la transazione
        $result = $this->gateway->transaction()->sale([
            'amount' => $sponsorship['price'],
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);

        //Controllo sulla transazione - relativo messaggio in sessione
        if ($result->success) {

            //assegno al dottore la sponsorizzazione
            $doctor->sponsorships()->sync([
                $sponsorship['id'] => ['end_date' => $endDate],
            ]);

            return redirect()->route('admin.doctor.payment')->with('success_message', 'Payment successful!');
        } else {

            $errorMessages = $result->message;

            return redirect()->route('admin.doctor.payment')->with('error_message', $errorMessages);
        }
    }
}
