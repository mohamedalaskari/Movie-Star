<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->block === 0) {
            $Genre = Genre::get();
            return $this->response(code: 200, data: $Genre);
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
    public function store(StoreGenreRequest $request)
    {
        if (Auth::user()->block === 0) {
            $request = $request->validated();
            //insert
            $insert = Genre::create($request);
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
    public function show(Genre $genre)
    {
        if (Auth::user()->block === 0) {
            $id = $genre->id;
            $genre = Genre::with('series', 'films')->find($id);
            return $this->response(code: 200, data: $genre);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        if (Auth::user()->block === 0) {
            //validate
            $request = $request->validated();
            //genre_id
            $genre_id = Genre::all()->where('genre', $request['genre'])->first()->id;
            //update data
            $update = DB::table('genres')->where('id', $genre_id)->update([
                'genre' => $request['genre_new'],
            ]);
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
    public function destroy(Genre $genre)
    {
        //
    }
    public function delete(Genre $genre)
    {
        if (Auth::user()->block === 0) {
            $delete = $genre->delete();
            return $this->response(code: 202, data: $delete);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function deleted(Genre $genre)
    {
        if (Auth::user()->block === 0) {
            $deleted = $genre->onlyTrashed()->get();
            return $this->response(code: 302, data: $deleted);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function restore($genre)
    {
        if (Auth::user()->block === 0) {
            $genre = Genre::withTrashed()->where('id', $genre)->restore();
            return $this->response(code: 202, data: $genre);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function delete_from_trash($genre)
    {
        if (Auth::user()->block === 0) {
            $genre  = Genre::where('id', $genre)->forceDelete();
            return $this->response(code: 202, data: $genre);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
}
