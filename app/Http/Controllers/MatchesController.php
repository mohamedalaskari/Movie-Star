<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Http\Requests\StoreMatchesRequest;
use App\Http\Requests\StoreWhereMatchRequest;
use App\Http\Requests\UpdateMatchesRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->block === 0) {
            $Matches = Matches::get();
            return $this->response(code: 200, data: $Matches);
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
    public function store(StoreMatchesRequest $request)
    {
        if (Auth::user()->block === 0) {
            $request = $request->validated();
            //insert
            $insert = Matches::create($request);
            //check if insert
            if ($insert) {
                return $this->response(code: 200, data: $insert);
            } else {
                return $this->response(code: 201);
            }
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Matches $matches)
    {
        if (Auth::user()->block === 0) {
            if ($this->Subscripe()) {
                $id = $matches->id;
                $matches = Matches::with('match_watchings', 'countries')->find($id);
                return $this->response(code: 200, data: $matches);
            } else {
                return 'you can\'t watch this episode untill pay it';
            }
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matches $matches)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatchesRequest $request, Matches $matches, StoreWhereMatchRequest $Match)
    {
        if (Auth::user()->block === 0) {
            //validate
            $request = $request->validated();
            $Match = $Match->validated();
            //update data
            $update = DB::table('matches')->where([['match_url', $Match['match_url_old']], ['champion', $Match['champion_old']]])->update($request);
            //check if update
            if ($update) {
                return $this->response(code: 200, data: $update);
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
    public function destroy(Matches $matches)
    {
        //
    }
    public function delete(Matches $matches)
    {
        if (Auth::user()->block === 0) {
            $delete = $matches->delete();
            return $this->response(code: 202, data: $delete);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function deleted(Matches $matches)
    {
        if (Auth::user()->block === 0) {
            $deleted = $matches->onlyTrashed()->get();
            return $this->response(code: 302, data: $deleted);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function restore($matches)
    {
        if (Auth::user()->block === 0) {
            $matches = Matches::withTrashed()->where('id', $matches)->restore();
            return $this->response(code: 202, data: $matches);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function delete_from_trash($matches)
    {
        if (Auth::user()->block === 0) {
            $matches  = Matches::where('id',  $matches)->forceDelete();
            return $this->response(code: 202, data: $matches);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
}