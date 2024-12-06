<?php

namespace App\Http\Controllers;

use App\Models\EpisodeWatching;
use App\Http\Requests\StoreEpisodeWatchingRequest;
use App\Http\Requests\UpdateEpisodeWatchingRequest;
use App\Models\Episode;
use App\Models\SubscriptionDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EpisodeWatchingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->block === 0) {
            $EpisodeWatching = EpisodeWatching::get();
            return $this->response(code: 200, data: $EpisodeWatching);
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
    public function store(StoreEpisodeWatchingRequest $request)
    {
        if (Auth::user()->block === 0) {
            if ($this->Subscripe()) {
                //validate
                $request = $request->validated();
                //user_id
                $user_id = Auth::user()->id;
                $request['user_id'] = $user_id;
                //insert data
                $insert = EpisodeWatching::create($request);
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
    public function show(EpisodeWatching $episodeWatching)
    {
        if (Auth::user()->block === 0) {
            $id = $episodeWatching->id;
            $episodeWatching = EpisodeWatching::with('users', 'episodes')->find($id);
            return $this->response(code: 200, data: $episodeWatching);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EpisodeWatching $episodeWatching)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEpisodeWatchingRequest $request, EpisodeWatching $episodeWatching)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EpisodeWatching $episodeWatching)
    {
        //
    }
    public function delete(EpisodeWatching $episodeWatching)
    {
        if (Auth::user()->block === 0) {
            $delete = $episodeWatching->delete();
            return $this->response(code: 202, data: $delete);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function deleted(EpisodeWatching $episodeWatching)
    {
        if (Auth::user()->block === 0) {
            $deleted = $episodeWatching->onlyTrashed()->get();
            return $this->response(code: 302, data: $deleted);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function restore($episodeWatching)
    {
        if (Auth::user()->block === 0) {
            $episodeWatching = EpisodeWatching::withTrashed()->where('id', $episodeWatching)->restore();
            return $this->response(code: 202, data: $episodeWatching);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function delete_from_trash($episodeWatching)
    {
        if (Auth::user()->block === 0) {
            $episodeWatching  = EpisodeWatching::where('id',  $episodeWatching)->forceDelete();
            return $this->response(code: 202, data: $episodeWatching);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
}
