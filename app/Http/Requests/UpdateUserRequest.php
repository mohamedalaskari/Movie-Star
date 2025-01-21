<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => "image|max:1024|mimes:png,jpg",
            'username' => 'required|string|max:30',
            'age' => 'required|max:2|regex:/\d/',
            'phone' => 'required|max:13|regex:/\d/|exists:users,phone',
            'email' => 'required|max:40|email|exists:users,email',
            'password' => 'required|confirmed|max:16|min:6'
        ];
    }
}
