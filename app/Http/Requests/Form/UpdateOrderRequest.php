<?php

namespace App\Http\Requests\Form;

use App\Enums\OrderStatus;

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
        $rules["status"] = [
            "nullable",
            "string",
            "max:255",
            "in:" . implode(",", OrderStatus::values())
        ];

        return $rules;
    }
}
