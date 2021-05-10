<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Arr;

class CheckoutController extends Controller
{
    public function index(){
        return Inertia::render("Checkout");
    }

    public function create(Request $request){
        Stripe::setApiKey('sk_test_BtSqxeVyQZEaTRyrdsMCTUmQ00mbIkYw4W');

        $intent = PaymentIntent::create([
            'amount' => $request->price * 100,
            'currency' => 'mad',
        ]);

        $clientSecret=Arr::get($intent,'client_secret');

        return response()->json(["clientSecret"=> $clientSecret,"total"=>$request->price]);

    }
}
