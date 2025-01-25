<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWhereCountryRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
    public function update(Request $Request, User $user, StoreWhereCountryRequest $storeWhereCountryRequest)
    {
        //user_id
        $user_id = Auth::user()->id;
        //upload image 
        $file = $Request->File('image');
        $request = $Request->validate(['image' => 'image|mimes:png,jpg,jpeg|max:2048']);
        $fileName = time() . '.' . $file->getClientOriginalName();
        $path = $request['image']->storeAs('user_images', $fileName, 'public');
        //validate data 
        $Request = $Request->validate([
            'username' => 'nullable|string|max:30|min:3',
            'age' => 'nullable|max:2|regex:/\d/',
            'phone' => "nullable|max:13|regex:/\d/|unique:users,phone,$user_id,id",
            'email' => "nullable|max:40|email|unique:users,email,$user_id,id",
            'password' => 'nullable|max:16|min:6'
        ]);

        if (!empty($Request['password'])) {
            $Request['password'] = Hash::make($Request['password']);
        }

        $storeWhereCountryRequest = $storeWhereCountryRequest->validated();
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