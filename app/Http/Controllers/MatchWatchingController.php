<?php

namespace App\Http\Controllers;

use App\Models\MatchWatching;
use App\Http\Requests\StoreMatchWatchingRequest;
use App\Http\Requests\UpdateMatchWatchingRequest;
use Illuminate\Support\Facades\Auth;

class MatchWatchingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->block === 0) {
            $MatchWatching = MatchWatching::get();
            return $this->response(code: 200, data: $MatchWatching);
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
    public function store(StoreMatchWatchingRequest $request)
    {
        if (Auth::user()->block === 0) {
            if ($this->Subscripe()) {
                //validate
                $request = $request->validated();
                //user_id
                $user_id = Auth::user()->id;
                $request['user_id'] = $user_id;
                //insert data
                $insert = MatchWatching::create($request);
                return $this->response(code: 201, data: $insert);
            } else {
                return $this->response(code: 500, msg: 'not payment');
            }
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MatchWatching $matchWatching)
    {
        if (Auth::user()->block === 0) {
            $id = $matchWatching->id;
            $matchWatching = MatchWatching::with('users', 'matches')->find($id);
            return $this->response(code: 200, data: $matchWatching);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MatchWatching $matchWatching)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatchWatchingRequest $request, MatchWatching $matchWatching)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MatchWatching $matchWatching)
    {
        //
    }
    public function delete(MatchWatching $matchWatching)
    {
        if (Auth::user()->block === 0) {
            $delete = $matchWatching->delete();
            return $this->response(code: 202, data: $delete);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function deleted(MatchWatching $matchWatching)
    {
        if (Auth::user()->block === 0) {
            $deleted = $matchWatching->onlyTrashed()->get();
            return $this->response(code: 302, data: $deleted);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function restore($matchWatching)
    {
        if (Auth::user()->block === 0) {
            $matchWatching = MatchWatching::withTrashed()->where('id', $matchWatching)->restore();
            return $this->response(code: 202, data: $matchWatching);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function delete_from_trash($matchWatching)
    {
        if (Auth::user()->block === 0) {
            $matchWatching  = MatchWatching::where('id', $matchWatching)->forceDelete();
            return $this->response(code: 202, data: $matchWatching);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
}
