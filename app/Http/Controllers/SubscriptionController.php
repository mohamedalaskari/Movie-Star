<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\StoreWhereSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->block === 0) {
            $Subscription = Subscription::get();
            return $this->response(code: 200, data: $Subscription);
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
    public function store(StoreSubscriptionRequest $request)
    {
        if (Auth::user()->block === 0) {
            $request = $request->validated();
            //insert data
            $insert = Subscription::create($request);
            if ($insert) {
                return $this->response(code: 201, data: $insert);
            } else {
                return $this->response(code: 400, data: 'Can\'t create ');
            }
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        if (Auth::user()->block === 0) {
            $id = $subscription->id;
            $subscription = Subscription::with('subscription_details')->find($id);
            return $this->response(code: 200, data: $subscription);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionRequest $request,  StoreWhereSubscriptionRequest $Subscription)
    {
        if (Auth::user()->block === 0) {
            //validate
            $request = $request->validated();
            $Subscription = $Subscription->validated();
            $subscription_id = Subscription::all()->where('name', $Subscription['name_old'])->first()->id;
            //updata data;
            $update = DB::table('subscriptions')->where('id', $subscription_id)->update($request);
            //check if update
            if ($update) {
                return $this->response(code: 201, data: $update);
            } else {
                return $this->response(code: 201);
            }
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
    public function delete(Subscription $subscription)
    {
        if (Auth::user()->block === 0) {
            $delete = $subscription->delete();
            return $this->response(code: 202, data: $delete);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function deleted(Subscription $subscription)
    {
        if (Auth::user()->block === 0) {
            $deleted = $subscription->onlyTrashed()->get();
            return $this->response(code: 302, data: $deleted);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function restore($subscription)
    {
        if (Auth::user()->block === 0) {
            $subscription = Subscription::withTrashed()->where('id', $subscription)->restore();
            return $this->response(code: 202, data: $subscription);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function delete_from_trash($subscription)
    {
        if (Auth::user()->block === 0) {
            $subscription  = Subscription::where('id', $subscription)->forceDelete();
            return $this->response(code: 202, data: $subscription);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
}
