<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Engins;


class PaymentController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('can:noneyet');      
    }
    //

    public function salesModalShow(int $enginId)
    {
        $engin = Engins::findOrfail($enginId);
        $data  = [
            'documentJustificatif' => $engin->documentJustificatif,
            'chassie' => $engin->chassie,
        ];
        dd($data);
        return view('guichet.enginModal')->with(' data', $data);
        // return response()->json( 'html'=> $returnHTML);
    }

     public function checkoutShow(Request $request) 
     {
            // dd($request);
           return view('payment');
     }


    public function checkout(Request $request) 
     {
           // get your logged in customer
           $customer = Auth::user();

           // when client hit checkout button
           if( $request->isMethod('post') ) 
           {
                // stripe customer payment token
                $stripe_token = $request->get('stripe_token');

                // make sure that if we do not have customer token already
                // then we create nonce and save it to our database
                if ( !$customer->stripe_token ) 
                {
                      // once we received customer payment nonce
                      // we have to save this nonce to our customer table
                      // so that next time user does not need to enter his credit card details
                      $result = \Stripe\Customer::create(array(
                          "email"  => $customer->email,
                          "source" => $stripe_token
                      ));

                      if( $result && $result->id )
                      {
                          $client->stripe_id = $result->id;
                          $client->stripe_token = $stripe_token;
                          $client->save();
                      }
                }

                if( $customer->stripe_token) 
                {
                    // charge customer with your amount
                    $result = \Stripe\Charge::create(array(
                         "currency" => "cad",
                         "customer" => $customer->stripe_id,
                         "amount"   => 200 // amount in cents                                                 
                    ));

                    // store transaction info for logs
                }             
           }

           return view('checkout');
     }
}
