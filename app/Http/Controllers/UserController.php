<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function user(): JsonResponse
    {
        return $this->sendResponse(new UserResource(request()->user()));
    }
}
