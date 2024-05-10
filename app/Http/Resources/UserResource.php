<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "fullName" => $this->full_name,
            "email" => $this->email,
            "is_admin" => $this->is_admin,
            "avatar" => new ImageResource($this->images->where("type", "profile-avatar")->first()),
        ];
    }
}
