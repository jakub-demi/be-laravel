<?php

namespace App\Http\Requests\Form;

class UpdateOrderRequest extends CreateOrderRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules["due_date"] = [
            "required",
            "date",
        ];
        $rules["payment_date"] = [
            "nullable",
            "date",
        ];
        $rules["created_at"] = [
            "required",
            "date",
        ];

        return $rules;
    }
}
