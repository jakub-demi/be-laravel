<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_orders()
    {
        $this->login();

        $response = $this->getJson("/api/orders");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_show_order()
    {
        $this->login();

        $order = Order::factory()->create();

        $response = $this->getJson("/api/orders/{$order->id}");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_order_correct_data()
    {
        $this->login();

        $data = Order::factory()->withCategory()->make()->only("customer_name", "customer_address", "due_date");

        $response = $this->postJson("/api/orders", $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_order_incorrect_data()
    {
        $this->login();

        $data = Order::factory()->make()->only("customer_name", "customer_address", "due_date");
        $data["due_date"] = now()->subDay()->toDateTimeString();

        $response = $this->postJson("/api/orders", $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_update_order_correct_data()
    {
        $this->login(true);

        $existingOrder = Order::factory()->create();
        $data = Order::factory()->withPaymentDate()->make()->only("customer_name", "customer_address", "due_date", "payment_date", "created_at");

        $response = $this->putJson("/api/orders/{$existingOrder->id}", $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_update_order_incorrect_data()
    {
        $this->login(true);

        $existingOrder = Order::factory()->create();
        $data = Order::factory()->make()->only("customer_name", "customer_address", "due_date");

        $response = $this->putJson("/api/orders/{$existingOrder->id}", $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_delete_existing_order()
    {
        $this->login(true);

        $existingOrder = Order::factory()->create();

        $response = $this->deleteJson("/api/orders/{$existingOrder->id}");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_delete_nonexisting_order()
    {
        $this->login(true);

        $response = $this->deleteJson("/api/orders/123456789");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_order_update_forbidden_access()
    {
        $this->login();

        $response = $this->putJson("/api/orders/123456789");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_order_delete_forbidden_access()
    {
        $this->login();

        $response = $this->deleteJson("/api/orders/123456789");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_order_pdf_generating()
    {
        $this->login();

        $existingOrder = Order::factory()->create();

        $response = $this->get("/api/orders/{$existingOrder->id}/generate-pdf");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertHeader("content-type", "application/pdf");
    }

    public function test_order_status_history()
    {
        $this->login();

        $existingOrder = Order::factory()->create();

        $response = $this->getJson("/api/orders/{$existingOrder->id}/status-history");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_order_statuses()
    {
        $this->login();

        $response = $this->getJson("/api/order-statuses");
        $response->assertStatus(Response::HTTP_OK);
    }
}
