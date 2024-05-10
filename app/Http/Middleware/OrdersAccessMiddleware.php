<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class OrdersAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $orderId = $request->route()->parameter("order");

        $access = $user->is_admin || ($orderId && $user->orders()->where("orders.id", "=", $orderId)->exists());

        if (!$access) {
            return Controller::sendResponse([], "Access Forbidden.", false, Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
