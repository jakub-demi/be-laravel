<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatusHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "order" => new OrderResource($this->order),
            "user" => new UserResource($this->user),
            "status" => new OrderStatusResource($this->status),
            "created_at" => $this->created_at,
        ];
    }
}
