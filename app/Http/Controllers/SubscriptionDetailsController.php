<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionDetails;
use App\Http\Requests\StoreSubscriptionDetailsRequest;
use App\Http\Requests\UpdateSubscriptionDetailsRequest;

class SubscriptionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $SubscriptionDetails = SubscriptionDetails::get();
        return $this->response(code: 200, data: $SubscriptionDetails);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionDetails $subscriptionDetails)
    {
        $id = $subscriptionDetails->id;
        $subscriptionDetails = SubscriptionDetails::with('users', 'subscriptions')->find($id);
        return $this->response(code: 200, data: $subscriptionDetails);
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
        $delete = $subscriptionDetails->delete();
        return $this->response(code: 202, data: $delete);
    }
    public function deleted(SubscriptionDetails $subscriptionDetails)
    {
        $deleted = $subscriptionDetails->onlyTrashed()->get();
        return $this->response(code: 302, data: $deleted);
    }
    public function restore( $subscriptionDetails)
    {
        $subscriptionDetails = SubscriptionDetails::withTrashed()->where('id', $subscriptionDetails)->restore();
        return $this->response(code: 202, data: $subscriptionDetails);
    }
    public function delete_from_trash( $subscriptionDetails)
    {
        $subscriptionDetails  = SubscriptionDetails::where('id', $subscriptionDetails)->forceDelete();
        return $this->response(code: 202, data: $subscriptionDetails);
    }
}
