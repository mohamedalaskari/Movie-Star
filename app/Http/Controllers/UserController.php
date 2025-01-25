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
    public function update(Request $request, UpdateUserRequest $Request, User $user, StoreWhereCountryRequest $storeWhereCountryRequest)
    {
        //upload image 
        $file = $request->File('image');
        $request = $request->validate(['image' => 'image|mimes:png,jpg,jpeg|max:2048']);
        $fileName = time() . '.' . $file->getClientOriginalName();
        $path = $request['image']->storeAs('image', $fileName, 'public');
        //validate data 
        $Request = $Request->validated();
        $storeWhereCountryRequest = $storeWhereCountryRequest->validated();
        //user_id
        $user_id = Auth::user()->id;
        //country_id
        $country_id = Country::all()->where('country', $storeWhereCountryRequest['country'])->first()->id;
        $Request['country_id'] = $country_id;
        $Request['image'] = $path;
        //update user
        $update = DB::table('users')->where('id', $user_id)->update($Request);
        if ($update) {
            return $this->response(code: 201, data: $update);
        } else {
            return $this->response(code: 401);
        }
    }
}