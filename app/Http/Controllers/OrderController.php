<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\Form\CreateOrderRequest;
use App\Http\Requests\Form\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderStatusHistoryResource;
use App\Http\Resources\OrderStatusResource;
use App\Interfaces\OrderRepositoryInterface;
use App\Services\OrderService;
use App\Services\OrderStatusHistoryService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly OrderStatusHistoryService $orderStatusHistoryService,
    ){}

    public function index(): JsonResponse
    {
        return self::sendResponse(OrderResource::collection($this->orderRepository->getAll()));
    }

    public function show(Request $request, int $id): JsonResponse
    {
        return self::sendResponse((new OrderResource($this->orderRepository->getById($id))));
    }

    public function store(CreateOrderRequest $request): JsonResponse
    {
        $data = $request->only("due_date", "order_users", "customer_name", "customer_address", "category_id");

        $order = $this->orderService->store($data);
        $resource = (new OrderResource($order));

        return self::sendResponse($resource, "Order #{$order->order_number} was created.");
    }

    public function update(UpdateOrderRequest $request, int $id): JsonResponse
    {
        $data = $request->only("due_date", "payment_date", "created_at", "order_users", "customer_name", "customer_address", "category_id");
        $status = $request->only("status");

        $order = $this->orderService->update($id, $data);
        $currentStatus = $order->status?->value;

        if (!empty($status)) {
            $status["status"] !== $currentStatus && $this->orderStatusHistoryService->changeStatus($id, $status["status"]);
        }

        $resource = (new OrderResource($order));

        return self::sendResponse($resource, "Order #{$order->order_number} was updated.");
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $orderNumber = $this->orderService->delete($id);

        return self::sendResponse([], "Order #{$orderNumber} was removed.");
    }

    public function generatePdf(Request $request, int $id): Response
    {
        $order = $this->orderRepository->getById($id);

        $pdf = Pdf::loadView("pdf.order-pdf", compact("order"));

        return $pdf->stream("order.pdf");
    }

    public function orderStatuses(): JsonResponse
    {
        return self::sendResponse(OrderStatusResource::collection(OrderStatus::cases()));
    }

    public function statusHistory(Request $request, int $id): JsonResponse
    {
        $statusHistories = $this->orderRepository->getStatusHistories($id);
        $resource = OrderStatusHistoryResource::collection($statusHistories);

        return self::sendResponse($resource);
    }
}
