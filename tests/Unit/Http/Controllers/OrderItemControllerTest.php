<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class OrderItemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_order_items()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->has(OrderItem::factory(4), "order_items")->create();

        $response = $this->getJson("/api/orders/{$order->id}/order-items");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_index_order_items_different_user()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->has(OrderItem::factory(4), "order_items")->create();
        $newUser = User::factory()->create();
        $this->actingAs($newUser, "sanctum");

        $response = $this->getJson("/api/orders/{$order->id}/order-items");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_show_order_item()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->has(OrderItem::factory(4), "order_items")->create();

        $response = $this->getJson("/api/orders/{$order->id}/order-items/{$order->order_items()->first()->id}");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_show_order_item_different_user()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->has(OrderItem::factory(4), "order_items")->create();
        $newUser = User::factory()->create();
        $this->actingAs($newUser, "sanctum");

        $response = $this->getJson("/api/orders/{$order->id}/order-items/{$order->order_items()->first()->id}");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_create_order_item_correct_data()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->create();
        $data = OrderItem::factory()->make()->toArray();

        $response = $this->postJson("/api/orders/{$order->id}/order-items", $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_order_item_incorrect_data()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->create();
        $data = OrderItem::factory()->make()->toArray();
        $data["cost"] = "something else than number";

        $response = $this->postJson("/api/orders/{$order->id}/order-items", $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_order_item_different_user()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->create();
        $data = OrderItem::factory()->make()->toArray();
        $newUser = User::factory()->create();
        $this->actingAs($newUser, "sanctum");

        $response = $this->postJson("/api/orders/{$order->id}/order-items", $data);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_update_order_item_correct_data()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->create();
        $existingOrderItem = OrderItem::factory()->for($order)->create();
        $data = OrderItem::factory()->make()->toArray();

        $response = $this->putJson("/api/orders/{$order->id}/order-items/{$existingOrderItem->id}", $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_update_order_item_incorrect_data()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->create();
        $existingOrderItem = OrderItem::factory()->for($order)->create();
        $data = OrderItem::factory()->make()->toArray();
        $data["vat"] = 999;

        $response = $this->putJson("/api/orders/{$order->id}/order-items/{$existingOrderItem->id}", $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_update_order_item_different_user()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->create();
        $existingOrderItem = OrderItem::factory()->for($order)->create();
        $data = OrderItem::factory()->make()->toArray();
        $newUser = User::factory()->create();
        $this->actingAs($newUser, "sanctum");

        $response = $this->putJson("/api/orders/{$order->id}/order-items/{$existingOrderItem->id}", $data);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_delete_existing_order_item()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->create();
        $existingOrderItem = OrderItem::factory()->for($order)->create();

        $response = $this->deleteJson("/api/orders/{$order->id}/order-items/{$existingOrderItem->id}");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_delete_nonexisting_order_item()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->create();

        $response = $this->deleteJson("/api/orders/{$order->id}/order-items/123456789");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delete_order_item_different_user()
    {
        $user = $this->login();

        $order = Order::factory()->hasAttached($user)->create();
        $existingOrderItem = OrderItem::factory()->for($order)->create();
        $newUser = User::factory()->create();
        $this->actingAs($newUser, "sanctum");

        $response = $this->deleteJson("/api/orders/{$order->id}/order-items/{$existingOrderItem->id}");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
