<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Http\Requests\StoreSeriesRequest;
use App\Http\Requests\StoreWhereGenreRequest;
use App\Http\Requests\UpdateSeriesRequest;
use App\Models\Genre;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Series = Series::get();
        return $this->response(code: 200, data: $Series);
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
    public function store(StoreSeriesRequest $request, StoreWhereGenreRequest $genre)
    {   //validate
        $request = $request->validated();
        $request['num_of_seasons'] = 0;
        //genre_id
        $genre = $genre->validated();
        $genre_id = Genre::all()->where('genre', $genre['genre'])->first()->id;
        $request['genre_id'] = $genre_id;
        //insert data
        $insert = Series::create($request);
        if ($insert) {
            return $this->response(code: 201, data: $insert);
        } else {
            return $this->response(code: 400, data: 'Can\'t create ');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Series $series)
    {
        $id = $series->id;
        $series = series::with('genres', 'seasons')->find($id);
        return $this->response(code: 200, data: $series);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Series $series)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeriesRequest $request, Series $series)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Series $series)
    {
        //
    }
    public function delete(Series $series)
    {
        $delete = $series->delete();
        return $this->response(code: 202, data: $delete);
    }
    public function deleted(Series $series)
    {
        $deleted = $series->onlyTrashed()->get();
        return $this->response(code: 302, data: $deleted);
    }
    public function restore( $series)
    {
        $series = Series::withTrashed()->where('id', $series)->restore();
        return $this->response(code: 202, data: $series);
    }
    public function delete_from_trash( $series)
    {
        $series  = Series::where('id', $series)->forceDelete();
        return $this->response(code: 202, data: $series);
    }
}
