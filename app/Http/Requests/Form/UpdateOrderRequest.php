<?php

namespace App\Http\Requests\Form;

class UpdateOrderRequest extends CreateOrderRequest
{
    public function rules(): array
    {
        return [
            "due_date" => [
                "required",
                "date",
            ],
            "payment_date" => [
                "nullable",
                "date",
            ],
            "created_at" => [
                "required",
                "date",
            ],
        ];
    }
}
