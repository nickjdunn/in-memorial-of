<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show() { return view('purchase'); }

    public function processPayment(Request $request)
    {
        $user = $request->user();
        $checkout = $user->checkout(env('STRIPE_PRICE_ID'), [
            'success_url' => route('purchase.success'),
            'cancel_url' => route('purchase.cancel'),
        ]);
        return redirect($checkout->url);
    }

    public function success(Request $request)
    {
        $user = $request->user();
        $user->increment('memorial_slots_purchased');
        return redirect()->route('dashboard')->with('status', 'Thank you! Your purchase was successful. You can now create a new memorial page.');
    }

    public function cancel(Request $request)
    {
        return redirect()->route('dashboard')->with('error', 'Your payment was cancelled. Please try again.');
    }
}