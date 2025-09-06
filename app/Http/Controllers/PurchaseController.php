<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display the purchase confirmation page.
     */
    public function show()
    {
        return view('purchase');
    }

    /**
     * Redirect the user to Stripe Checkout.
     */
    public function processPayment(Request $request)
    {
        $user = $request->user();

        // NOTE: We are still using the Stripe Price ID here.
        // The price is managed in your Stripe Dashboard.
        // For one-time charges, this is the recommended approach.
        // We will update the display text in the views.
        $checkout = $user->checkout(env('STRIPE_PRICE_ID'), [
            'success_url' => route('purchase.success'),
            'cancel_url' => route('purchase.cancel'),
        ]);

        return redirect($checkout->url);
    }

    /**
     * Handle the successful payment callback from Stripe.
     */
    public function success(Request $request)
    {
        $user = $request->user();
        $user->increment('memorial_slots_purchased');

        return redirect()->route('dashboard')->with('status', 'Thank you! Your purchase was successful. You can now create a new memorial page.');
    }

    /**
     * Handle the cancelled payment callback from Stripe.
     */
    public function cancel(Request $request)
    {
        return redirect()->route('dashboard')->with('error', 'Your payment was cancelled. Please try again.');
    }
}