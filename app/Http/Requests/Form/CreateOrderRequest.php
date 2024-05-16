<?php

namespace App\Http\Requests\Form;

use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    )
    {
        parent::__construct();
    }

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
                "after:today",
            ],
            "order_users" => "nullable|array",
            "customer_name" => "required|string|max:255",
            "customer_address" => "required|string|max:255",
            "category_id" => "nullable|int|in:" . implode(",", $this->categoryRepository->getAllIds())
        ];
    }
}
