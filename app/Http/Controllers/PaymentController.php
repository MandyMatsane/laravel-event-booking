<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Log;



class PaymentController extends Controller
{
    public function checkout(Booking $booking)
    {
        //retrieves the paypal credentials
        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $token = $paypal->getAccessToken();
        $paypal->setAccessToken($token);

        //Validate the tickets's price
        $ticketPrice = $booking->event->ticket_price;

        if (!$ticketPrice || $ticketPrice <= 0) {
            return redirect()->route('bookings.index')
                ->with('error', 'Ticket price is not set or invalid.');
        }

        // Log the PayPal order request
        Log::info('PayPal Order Request:', [
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($ticketPrice, 2, '.', ''),
                    ],
                ],
            ],
        ]);

        //creating the paypal order
        $order = $paypal->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format($ticketPrice, 2, '.', ''),
                    ],
                ],
            ],
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
        ]);

        // Log the PayPal order response
        Log::info('PayPal Order Response:', $order);

        //redirect to paypal approval page
        if (isset($order['links']) && is_array($order['links'])) {
            foreach ($order['links'] as $link) {  
                if ($link['rel'] === 'approve') {
                    return redirect($link['href']);
                }
            }
        }


        // if (isset($order['links']) && is_array($order['links'])) {
        //     foreach ($order['links'] as $link) {
        //         if ($link['rel'] === 'approve') {
        //             return redirect($link['href']);
        //         }
        //     }
        // }

        return redirect()->route('bookings.index')->with('error', 'Something went wrong with PayPal.');
    }

    public function success(Request $request)
    {
        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $token = $paypal->getAccessToken();
        $paypal->setAccessToken($token);

        // Retrieve the token from the request
        $orderToken = $request->query('token');

        // Check if the token is present
        if (!$orderToken) {
            Log::error('PayPal token is missing in the request.', ['request' => $request->all()]);
            return redirect()->route('bookings.index')->with('error', 'PayPal token is missing. Payment could not be verified.');
        }

        try {
            // Capture the payment order
            $result = $paypal->capturePaymentOrder($orderToken);

            // Check if the payment is completed
            if ($result['status'] === 'COMPLETED') {
                // Update booking payment status
                $bookingId = $result['purchase_units'][0]['reference_id'] ?? null;
                $booking = Booking::find($bookingId);

                if ($booking) {
                    $booking->update(['payment_status' => 'Paid']);
                    return redirect()->route('bookings.index')->with('success', 'Payment successful!');
                }

                Log::error('Booking not found for the given reference ID.', ['reference_id' => $bookingId]);
                return redirect()->route('bookings.index')->with('error', 'Booking not found.');
            }

            Log::error('PayPal payment not completed.', ['result' => $result]);
            return redirect()->route('bookings.index')->with('error', 'Payment not completed.');
        } catch (\Exception $e) {
            Log::error('Error capturing PayPal payment order.', ['exception' => $e->getMessage()]);
            return redirect()->route('bookings.index')->with('error', 'An error occurred while processing your payment.');
        }
    }


    public function cancel()
    {
        return redirect()->route('bookings.index')->with('error', 'Payment was cancelled.');
    }
}
