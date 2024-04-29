<?php

namespace App\Http\Requests\Form;

use App\Enums\VatRate;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|max:255",
            "count" => "required|int|min:1",
            "cost" => "required|numeric|min:0.00|max:9999999.99",
            "vat" => ["required", "in:" . implode(",", VatRate::values())],
        ];
    }
}
