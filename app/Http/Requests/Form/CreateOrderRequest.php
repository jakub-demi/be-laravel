<?php

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "due_date" => [
                "required",
                "date",
                "after:today"
            ],
        ];
    }
}