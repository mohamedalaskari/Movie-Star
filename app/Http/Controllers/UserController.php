<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = User::paginate(30);
        return $this->response(code: 200, data: $user);
    }

    public function show(User $user)
    {
        $id = $user->id;
        $user = User::with('country', 'subscription_details', 'film_watchings', 'match_watchings', 'episode_watchings')->find($id);
        return $this->response(code: 200, data: $user);
    }
}