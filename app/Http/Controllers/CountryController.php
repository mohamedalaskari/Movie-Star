<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (Auth::user()->block === 0) {
            $country = Country::get();
            return $this->response(code: 200, data: $country);
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
    public function store(StoreCountryRequest $request)
    {
        if (Auth::user()->block === 0) {
            $request = $request->validated();
            $insert = Country::create($request);
            if ($insert) {
                return $this->response(code: 200, data: $insert);
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
    public function show(Country $country)
    {
        if (Auth::user()->block === 0) {
            $id = $country->id;
            $country = Country::with('users')->find($id);
            return $this->response(code: 200, data: $country);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        if (Auth::user()->block === 0) {
            $request = $request->validated();
            //country_id
            $country_id = Country::all()->where('country', $request['country'])->first()->id;
            //update country
            $update = DB::table('countries')->where('id', $country_id)->update([
                'country' => $request['country_update']
            ]);
            if ($update) {
                return $this->response(code: 201, data: $update);
            } else {
                return $this->response(code: 401);
            }
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        //
    }
    public function restore(Country $country)
    {
        if (Auth::user()->block === 0) {
            $restore = Country::withTrashed()->where('id', $country)->restore();
            return $this->response(code: 202, data: $restore);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function delete(Country $country)
    {
        if (Auth::user()->block === 0) {
            $delete = $country->delete();
            return $this->response(code: 202, data: $delete);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function deleted($country)
    {
        if (Auth::user()->block === 0) {
            $deleted = $country->onlyTrashed()->get();
            return $this->response(code: 302, data: $deleted);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function delete_from_trash($country)
    {
        if (Auth::user()->block === 0) {
            $Country  = Country::where('id', $country)->forceDelete();
            return $this->response(code: 202, data: $Country);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
}
