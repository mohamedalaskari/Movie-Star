<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWhereEpisodeRequest extends FormRequest
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
            'series_name_old' => 'required|max:40|exists:series,series_name',
            'season_number_old' => 'required|exists:seasons,season_number|max:3|regex:/\d/',
            'episode_number_old' => 'required|max:50|string',

        ];
    }
}
