<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\CreateOrderItemRequest;
use App\Http\Requests\Form\UpdateOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Interfaces\OrderItemRepositoryInterface;
use App\Services\OrderItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function __construct(
        private readonly OrderItemRepositoryInterface $orderItemRepository,
        private readonly OrderItemService $orderItemService
    ){}

    public function index(Request $request, int $orderId)
    {
        $resource = OrderItemResource::collection($this->orderItemRepository->getAllByOrderId($orderId));
        self::sendResponse($resource);
    }

    public function show(Request $request, int $id)
    {
        $resource = new OrderItemResource($this->orderItemRepository->getById($id));
        self::sendResponse($resource);
    }

    public function store(CreateOrderItemRequest $request, int $orderId): JsonResponse
    {
        $data = $request->only("name", "count", "cost", "vat"); // !dev - cost_with_vat is calculated in observer

        $orderItem = $this->orderItemService->store($orderId, $data);
        $resource = (new OrderItemResource($orderItem));

        return self::sendResponse($resource, "Order item '{$orderItem->name}' was created.");
    }

    public function update(UpdateOrderItemRequest $request, int $id): JsonResponse
    {
        $data = $request->only("name", "count", "cost", "vat");

        $orderItem = $this->orderItemService->update($id, $data);
        $resource = (new OrderItemResource($orderItem));

        return self::sendResponse($resource, "Order item '{$orderItem->name}' was updated.");
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $orderItemName = $this->orderItemService->delete($id);

        return self::sendResponse([], "Order item '{$orderItemName}' was removed.");
    }
}
