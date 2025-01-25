<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFilmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description'=>'required|string|max:150',
            'name'=>'required|string|max:30',
            'film_url'=>'required|max:1024|file',
            'image' => 'file',
            'story' => 'required' , 
            'quality' => 'required',
            'year_of_production' =>'required',
            'rate' => 'required' ,
            'top_10' => 'required',
            'country_id' => 'required|exists:countries,country'
        ];
    }
}
