<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Http\Requests\StoreMatchesRequest;
use App\Http\Requests\UpdateMatchesRequest;

class MatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Matches = Matches::get();
        return $this->response(code: 200, data: $Matches);
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
        $request = $request->validated();
        //insert
        $insert = Matches::create($request);
        //check if insert
        if($insert){
            return $this->response(code:200 , data:$insert);
        }else{
            return $this->response(code:201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Matches $matches)
    {
        $id = $matches->id;
        $matches = Matches::with('match_watchings')->find($id);
        return $this->response(code: 200, data: $matches);
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
    public function update(UpdateMatchesRequest $request, Matches $matches)
    {
        //
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
        $delete = $matches->delete();
        return $this->response(code: 202, data: $delete);
    }
    public function deleted(Matches $matches)
    {
        $deleted = $matches->onlyTrashed()->get();
        return $this->response(code: 302, data: $deleted);
    }
    public function restore( $matches)
    {
        $matches = Matches::withTrashed()->where('id', $matches)->restore();
        return $this->response(code: 202, data: $matches);
    }
    public function delete_from_trash( $matches)
    {
        $matches  = Matches::where('id',  $matches)->forceDelete();
        return $this->response(code: 202, data: $matches);
    }
}
