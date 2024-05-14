<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    public static function sendResponse(
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
