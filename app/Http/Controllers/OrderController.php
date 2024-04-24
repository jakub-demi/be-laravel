<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\CreateOrderRequest;
use App\Http\Requests\Form\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Interfaces\OrderRepositoryInterface;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
        private readonly OrderRepositoryInterface $orderRepository,
    ){}

    public function index(): JsonResponse
    {
        return $this->sendResponse(OrderResource::collection($this->orderRepository->getAll()));
    }

    public function show(Request $request, int $id): JsonResponse
    {
        return $this->sendResponse((new OrderResource($this->orderRepository->getById($id))));
    }

    public function store(CreateOrderRequest $request): JsonResponse
    {
        $data = $request->only("due_date");

        $order = $this->orderService->store($data);
        $resource = (new OrderResource($order));

        return $this->sendResponse($resource, "Order #{$order->order_number} was created.");
    }

    public function update(UpdateOrderRequest $request, int $id): JsonResponse
    {
        $data = $request->only("due_date");

        $order = $this->orderService->update($id, $data);
        $resource = (new OrderResource($order));

        return $this->sendResponse($resource, "Order #{$order->order_number} was updated.");
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $orderNumber = $this->orderService->delete($id);

        return $this->sendResponse([], "Order #{$orderNumber} was removed.");
    }
}
