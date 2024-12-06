<?php

namespace App\Http\Controllers;

use App\Models\FilmWatching;
use App\Http\Requests\StoreFilmWatchingRequest;
use App\Http\Requests\UpdateFilmWatchingRequest;
use Illuminate\Support\Facades\Auth;

class FilmWatchingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->block === 0) {
            $FilmWatching = FilmWatching::get();
            return $this->response(code: 200, data: $FilmWatching);
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
    public function store(StoreFilmWatchingRequest $request)
    {
        if (Auth::user()->block === 0) {
            if ($this->Subscripe()) {
                //validate
                $request = $request->validated();
                //user_id
                $user_id = Auth::user()->id;
                $request['user_id'] = $user_id;
                //insert data
                $insert = FilmWatching::create($request);
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
    public function show(FilmWatching $filmWatching)
    {
        if (Auth::user()->block === 0) {
            $id = $filmWatching->id;
            $filmWatching = FilmWatching::with('users', 'films')->find($id);
            return $this->response(code: 200, data: $filmWatching);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FilmWatching $filmWatching)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilmWatchingRequest $request, FilmWatching $filmWatching)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FilmWatching $filmWatching)
    {
        //
    }
    public function delete(FilmWatching $filmWatching)
    {
        if (Auth::user()->block === 0) {
            $delete = $filmWatching->delete();
            return $this->response(code: 202, data: $delete);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function deleted(FilmWatching $filmWatching)
    {
        if (Auth::user()->block === 0) {
            $deleted = $filmWatching->onlyTrashed()->get();
            return $this->response(code: 302, data: $deleted);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function restore($filmWatching)
    {
        if (Auth::user()->block === 0) {
            $filmWatching = FilmWatching::withTrashed()->where('id', $filmWatching)->restore();
            return $this->response(code: 202, data: $filmWatching);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function delete_from_trash($filmWatching)
    {
        if (Auth::user()->block === 0) {
            $filmWatching  = FilmWatching::where('id', $filmWatching)->forceDelete();
            return $this->response(code: 202, data: $filmWatching);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
}
