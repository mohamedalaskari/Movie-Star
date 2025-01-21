<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWhereCountryRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function update(UpdateUserRequest $request, User $user, StoreWhereCountryRequest $storeWhereCountryRequest)
    {

        $request = $request->validated();
        $storeWhereCountryRequest = $storeWhereCountryRequest->validated();
        //user_id
        $user_id = Auth::user()->id;
        //country_id
        $country_id = Country::all()->where('country', $storeWhereCountryRequest['country'])->first()->id;
        $request['country_id'] = $country_id;
        //update user
        $update = DB::table('users')->where('id', $user_id)->update($request);
        if ($update) {
            return $this->response(code: 201, data: $update);
        } else {
            return $this->response(code: 401);
        }
    }
}
