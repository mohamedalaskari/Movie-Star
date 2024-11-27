<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Requests\StoreWhereCountryRequest;
use App\Models\Country;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{

    public function Register(StoreRegisterRequest $Request, StoreWhereCountryRequest $country)
    {
        $Request = $Request->validated();
        //hash password
        $Request['password'] = Hash::make($Request['password']);
        //find country_id
        $country = $country->validated();
        $country_id = Country::all()->where('country', $country['country'])->first()->id;
        $Request['country_id'] = $country_id;
        //insert data
        $insert = User::create($Request);
        //check if user created
        if ($insert) {
            return $this->response(code: 201, data: $insert);
        } else {
            return $this->response(code: 400, data: 'Can\'t register');
        }
    }
    public function Login(StoreLoginRequest $request)
    {
        $request = $request->validated();
        //$request = str_replace(' ', '', $request);
        $Auth = Auth::attempt($request);
        if ($Auth) {
            $user = Auth::user();
            $token = $user->createToken('front-end', [$user->role], Carbon::now()->addDays(7))->plainTextToken;
            $user['token'] = $token;
            return $this->response(code: 200, data: $user);
        } else {
            return $this->response(code: 401);
        }
    }
    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        $currentToken = PersonalAccessToken::findToken($token);
        if ($currentToken) {
            if ($currentToken->delete()) {
                return $this->response(code: 202, msg: 'Logged out successfully');
            }
        } else {
            return $this->response(code: 404, msg: 'Cannot log out at the moment');
        }
    }
    public function logout_all()
    {
        $logout = Auth::user()->tokens()->delete();
        if ($logout) {
            return $this->response(code: 202, msg: 'Logged out from all devices successfully');
        } else {
            return $this->response(code: 404, msg: 'Cannot log out at the moment');
        }
    }
}
