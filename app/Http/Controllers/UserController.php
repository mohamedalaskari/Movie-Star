<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->block === 0) {
            $user = User::get();
            return $this->response(code: 200, data: $user);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }

    public function show(User $user)
    {
        if (Auth::user()->block === 0) {
            $id = $user->id;
            $user = User::with('countries', 'subscription_details', 'film_watchings', 'match_watchings', 'episode_watchings')->find($id);
            return $this->response(code: 200, data: $user);
        } else {
            return $this->response(code: 401, msg: "You cannot log in because you are blocked.");
        }
    }
}