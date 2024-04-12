<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    public function sendResponse(
        mixed $data,
        string $message = null,
        bool $success = true,
        int $statusResponse = Response::HTTP_OK
    ): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'success' => $success,
        ], $statusResponse);
    }
}
