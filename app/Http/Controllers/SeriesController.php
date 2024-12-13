<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Http\Requests\StoreSeriesRequest;
use App\Http\Requests\StoreWhereGenreRequest;
use App\Http\Requests\StoreWhereSeriesRequest;
use App\Http\Requests\UpdateSeriesRequest;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->block === 0) {
            $Series = Series::get();
            return $this->response(code: 200, data: $Series);
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
    public function store(StoreSeriesRequest $request, StoreWhereGenreRequest $genre)
    {
        if (Auth::user()->block === 0) {
            //validate
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
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Series $series)
    {
        if (Auth::user()->block === 0) {
            $id = $series->id;
            $series = series::with('genres', 'seasons', 'countries')->find($id);
            return $this->response(code: 200, data: $series);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
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
    public function update(UpdateSeriesRequest $request, StoreWhereSeriesRequest $Series, StoreWhereGenreRequest $genre)
    {
        if (Auth::user()->block === 0) {
            //validate
            $request = $request->validated();
            $genre = $genre->validated();
            $Series = $Series->validated();
            //genre_id
            $genre_id = Genre::all()->where('genre', $genre['genre'])->first()->id;
            $request['genre_id'] = $genre_id;
            //Series_id
            $Series_id = Series::all()->where('series_name', $Series['series_name'])->first()->id;
            //update data
            $update = DB::table('series')->where('id', $Series_id)->update($request);
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
    public function destroy(Series $series)
    {
        //
    }
    public function delete(Series $series)
    {
        if (Auth::user()->block === 0) {
            $delete = $series->delete();
            return $this->response(code: 202, data: $delete);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function deleted(Series $series)
    {
        if (Auth::user()->block === 0) {
            $deleted = $series->onlyTrashed()->get();
            return $this->response(code: 302, data: $deleted);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function restore($series)
    {
        if (Auth::user()->block === 0) {
            $series = Series::withTrashed()->where('id', $series)->restore();
            return $this->response(code: 202, data: $series);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function delete_from_trash($series)
    {
        if (Auth::user()->block === 0) {
            $series  = Series::where('id', $series)->forceDelete();
            return $this->response(code: 202, data: $series);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
}
