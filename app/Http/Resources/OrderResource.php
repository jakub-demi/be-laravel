<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array|JsonSerializable|Arrayable
    {
        return [
            "id" => $this->id,
            "order_number" => $this->order_number,
            "due_date" => $this->due_date,
            "payment_date" => $this->payment_date,
            "created_at" => $this->created_at,
            "has_access" => $this->hasAccess(),
            "customer_name" => $this->customer_name,
            "customer_address" => $this->customer_address,
            "order_users" => UserResource::collection($this->users()->get()),
            "category" => new CategoryResource($this->category),
            "current_status" => new OrderStatusResource($this->status),
        ];
    }
}
