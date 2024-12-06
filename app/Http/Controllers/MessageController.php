<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->block === 0) {
            $Message = Message::get();
            return $this->response(code: 200, data: $Message);
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
    public function store(StoreMessageRequest $request)
    {
        if (Auth::user()->block === 0) {
            $request = $request->validated();
            $user_id = Auth::user()->id;
            $request['user_id'] = $user_id;
            //insert
            $insert = Message::create($request);
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
    public function show(Message $message)
    {
        if (Auth::user()->block === 0) {
            $id = $message->id;
            $message = Message::with('users')->find($id);
            return $this->response(code: 200, data: $message);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
    public function delete(Message $message)
    {
        if (Auth::user()->block === 0) {
            $delete = $message->delete();
            return $this->response(code: 202, data: $delete);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function deleted(Message $message)
    {
        if (Auth::user()->block === 0) {
            $deleted = $message->onlyTrashed()->get();
            return $this->response(code: 302, data: $deleted);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function restore($message)
    {
        if (Auth::user()->block === 0) {
            $message = Message::withTrashed()->where('id', $message)->restore();
            return $this->response(code: 202, data: $message);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
    public function delete_from_trash($message)
    {
        if (Auth::user()->block === 0) {
            $message  = Message::where('id',  $message)->forceDelete();
            return $this->response(code: 202, data: $message);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
}
