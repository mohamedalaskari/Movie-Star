<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreWhereGenreRequest;
use App\Models\Film;
use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\StoreWhereFilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use App\Models\Genre;

use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function new()
    {
        $new = Film::select(['id', 'image', 'story', 'quality', 'year_of_production', 'rate', 'top_10', 'country_id', 'genre_id', 'name', 'description'])->with('genre', 'country')->orderBy('id', 'desc')->limit(15)->get();
        if (count($new) != 0) {
            return $this->response(code: 200, data: $new);
        } else {
            return $this->response(code: 404);
        }
    }
    public function top_10()
    {
        $top_10 = Film::select(['id', 'image', 'story', 'quality', 'year_of_production', 'rate', 'top_10', 'country_id', 'genre_id', 'name', 'description'])->with('genre', 'country')->get()->where('top_10', true);
        if (count($top_10) != 0) {
            return $this->response(code: 200, data: $top_10);
        } else {
            return $this->response(code: 404);
        }
    }
    public function rate()
    {
        $films = Film::select(['id', 'image', 'story', 'quality', 'year_of_production', 'rate', 'top_10', 'country_id', 'genre_id', 'name', 'description'])->with('genre', 'country')->get()->where('rate', '>', '7.0');
        if (count($films) != 0) {
            return $this->response(code: 200, data: $films);
        } else {
            return $this->response(code: 404);
        }
    }
    public function genre($genre)
    {
        //get genre id
        $genre_id = Genre::all()->where('genre', $genre)->first()->id;
        //get film where genre
        $films = Film::select(['id', 'image', 'story', 'quality', 'year_of_production', 'rate', 'top_10', 'country_id', 'genre_id', 'name', 'description'])->with('genre', 'country')->get()->where('genre_id', $genre_id);
        if ($films) {
            return $this->response(code: 200, data: $films);
        } else {
            return $this->response(code: 404);
        }
    }
    public function index()
    {
        $Film = Film::select(['id', 'image', 'story', 'quality', 'year_of_production', 'rate', 'top_10', 'country_id', 'genre_id', 'name', 'description'])
            ->with('genre', 'country')->paginate(30);
        return $this->response(code: 200, data: $Film);
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
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        if ($this->Subscripe()) {
            $id = $film->id;
            $film = Film::with('genre', 'film_watchings', 'country')->find($id);
            return $this->response(code: 200, data: $film);
        } else {
            return 'you can\'t watch this episode untill pay it';
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
        $delete = $film->delete();
        return $this->response(code: 202, data: $delete);
    }
    public function deleted(Film $film)
    {
        $deleted = $film->onlyTrashed()->get();
        return $this->response(code: 302, data: $deleted);
    }
    public function restore($film)
    {
        $film = Film::withTrashed()->where('id', $film)->restore();
        return $this->response(code: 202, data: $film);
    }
    public function delete_from_trash($film)
    {
        $film = Film::where('id', $film)->forceDelete();
        return $this->response(code: 202, data: $film);
    }
}
