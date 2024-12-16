<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWhereGenreRequest;
use App\Models\Film;
use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\StoreWhereFilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->block === 0) {
            $Film = Film::get();
            return $this->response(code: 200, data: $Film);
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
    public function store(StoreFilmRequest $request, StoreWhereGenreRequest $genre)
    {
        if (Auth::user()->block === 0) {
            $request = $request->validated();
            $genre = $genre->validated();
            //get genre_id
            $genre_id = Genre::all()->where('genre', $genre['genre'])->first()->id;
            //add genre_id to request
            $request['genre_id'] = $genre_id;
            //store film
            $insert = Film::create($request);
            //check if inserted
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
    public function show(Film $film)
    {
        if (Auth::user()->block === 0) {
            if ($this->Subscripe()) {
                $id = $film->id;
                $film = Film::with('genres', 'film_watchings', 'countries')->find($id);
                return $this->response(code: 200, data: $film);
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
    public function edit(Film $film)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilmRequest $request, StoreWhereGenreRequest $genre, StoreWhereFilmRequest $film)
    {
        if (Auth::user()->block === 0) {
            $request = $request->validated();
            $genre = $genre->validated();
            $film = $film->validated();
            //find genre_id
            $genre_id = Genre::all()->where('genre', $genre['genre'])->first()->id;
            $request['genre_id'] = $genre_id;
            //update
            $update = DB::table('films')->where('name', $film['name'])->update([
                'description' => $request['description'],
                'name' => $request['name_new'],
                'film_url' => $request['film_url'],
                'genre_id' => $request['genre_id']
            ]);
            //check if updated
            if ($update) {
                return $this->response(code: 200, data: $update);
            } else {
                return $this->response(code: 201);
            }
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        //
    }
    public function delete(Film $film)
    {
        if (Auth::user()->block === 0) {
            $delete = $film->delete();
            return $this->response(code: 202, data: $delete);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function deleted(Film $film)
    {
        if (Auth::user()->block === 0) {
            $deleted = $film->onlyTrashed()->get();
            return $this->response(code: 302, data: $deleted);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function restore($film)
    {
        if (Auth::user()->block === 0) {
            $film = Film::withTrashed()->where('id', $film)->restore();
            return $this->response(code: 202, data: $film);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function delete_from_trash($film)
    {
        if (Auth::user()->block === 0) {
            $film  = Film::where('id', $film)->forceDelete();
            return $this->response(code: 202, data: $film);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
}
