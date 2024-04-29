<?php

namespace App\Http\Requests\Form;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends CreateUserRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules["email"] = ["required", "string", "email", "max:255"];
        $rules["password"] = ["nullable", "string", Password::default(), "confirmed"];
        return $rules;
    }
}
