<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionDetails;
use App\Http\Requests\StoreSubscriptionDetailsRequest;
use App\Http\Requests\StoreWhereSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionDetailsRequest;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SubscriptionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->block === 0) {
            $SubscriptionDetails = SubscriptionDetails::get();
            return $this->response(code: 200, data: $SubscriptionDetails);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public $stripe;
    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET', 'sk_test_51Q7zvlAKd03pxsFrF39kPa8qKdtfqRTZgVgdqsDKsZBkX8ue2YBTN951t8DOeoWhOd0658fI1S3v7BXqSrYTT0RN00RZnk4hEG'));
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET', 'sk_test_51Q7zvlAKd03pxsFrF39kPa8qKdtfqRTZgVgdqsDKsZBkX8ue2YBTN951t8DOeoWhOd0658fI1S3v7BXqSrYTT0RN00RZnk4hEG'));
    }
    public function pay(StoreWhereSubscriptionRequest $request)
    {
        if (Auth::user()->block === 0) {
            $request = $request->validated();
            $Subscription = Subscription::all()->where('name', $request['name_old'])->first();
            $user = Auth::user();
            $User = $this->stripe->customers->create([
                'name' => $user['username'],
                'email' => $user['email'],
                'phone' => $user['phone'],
            ]);
            $checkout_session = $this->stripe->checkout->sessions->create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $Subscription['name'],
                            'description' => $Subscription['period'],
                        ],
                        'unit_amount' => $Subscription['price'] * 100,
                    ],
                    'quantity' => 1,
                ]],
                'customer_email' => $user['email'],
                'mode' => 'payment',
                //Subscription_id
                'client_reference_id' => $Subscription['id'],
                'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
            ]);
            return $checkout_session->url;
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    public function cancel()
    {
        if (Auth::user()->block === 0) {
            return "Payment is canceled.";
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionDetailsRequest $request)
    {
        if (Auth::user()->block === 0) {
            if (isset($request->session_id)) {

                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET', 'sk_test_51Q7zvlAKd03pxsFrF39kPa8qKdtfqRTZgVgdqsDKsZBkX8ue2YBTN951t8DOeoWhOd0658fI1S3v7BXqSrYTT0RN00RZnk4hEG'));
                $response = $stripe->checkout->sessions->retrieve($request->session_id);
                //user_id
                $user_id = Auth::user()->id;
                $request['user_id'] = $user_id;
                //subscription_id
                $subscription_id = $response->client_reference_id;
                $request['subscription_id'] = $subscription_id;
                //insert_data
                $insert_data = SubscriptionDetails::create([
                    'user_id' => $user_id,
                    'subscription_id' => $subscription_id,
                ]);
                return $this->response(code: 201, msg: "Payment is successful");
            }
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionDetails $subscriptionDetails)
    {
        if (Auth::user()->block === 0) {
            $id = $subscriptionDetails->id;
            $subscriptionDetails = SubscriptionDetails::with('users', 'subscriptions')->find($id);
            return $this->response(code: 200, data: $subscriptionDetails);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubscriptionDetails $subscriptionDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionDetailsRequest $request, SubscriptionDetails $subscriptionDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionDetails $subscriptionDetails)
    {
        //
    }
    public function delete(SubscriptionDetails $subscriptionDetails)
    {
        if (Auth::user()->block === 0) {
            $delete = $subscriptionDetails->delete();
            return $this->response(code: 202, data: $delete);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function deleted(SubscriptionDetails $subscriptionDetails)
    {
        if (Auth::user()->block === 0) {
            $deleted = $subscriptionDetails->onlyTrashed()->get();
            return $this->response(code: 302, data: $deleted);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function restore($subscriptionDetails)
    {
        if (Auth::user()->block === 0) {
            $subscriptionDetails = SubscriptionDetails::withTrashed()->where('id', $subscriptionDetails)->restore();
            return $this->response(code: 202, data: $subscriptionDetails);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function delete_from_trash($subscriptionDetails)
    {
        if (Auth::user()->block === 0) {
            $subscriptionDetails  = SubscriptionDetails::where('id', $subscriptionDetails)->forceDelete();
            return $this->response(code: 202, data: $subscriptionDetails);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
}
