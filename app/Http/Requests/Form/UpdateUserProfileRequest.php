<?php

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [ 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user()->id) ],
            'firstname' => [ 'required', 'string', 'max:255' ],
            'lastname' => [ 'required', 'string', 'max:255' ],
            'avatar' => [ 'nullable', 'image', 'mimes:jfif,jpeg,jpg,png', 'max:10486' ]
        ];
    }
}
