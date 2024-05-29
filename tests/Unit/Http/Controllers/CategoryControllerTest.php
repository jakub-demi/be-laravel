<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_order_categories()
    {
        $this->login();

        Category::factory(4)->create();

        $response = $this->getJson("/api/order-categories");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_show_order_category()
    {
        $this->login();

        $category = Category::factory()->create();

        $response = $this->getJson("/api/order-categories/{$category->id}");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_order_category_correct_data()
    {
        $this->login(true);

        $data = Category::factory()->make()->toArray();
        $slug = Str::slug($data["name"]);

        $response = $this->postJson("/api/order-categories", $data);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertTrue($response->getOriginalContent()["data"]->slug === $slug);
    }

    public function test_create_order_category_incorrect_data()
    {
        $this->login(true);

        $data = [
            "something" => "else",
        ];

        $response = $this->postJson("/api/order-categories", $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_update_order_category_correct_data()
    {
        $this->login(true);

        $existingCategory = Category::factory()->create();
        $slug = Str::slug($existingCategory->name);
        $data = Category::factory()->make()->toArray();

        $response = $this->putJson("/api/order-categories/{$existingCategory->id}", $data);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertTrue($response->getOriginalContent()["data"]->slug === $slug);
    }

    public function test_delete_existing_order_category()
    {
        $this->login(true);

        $existingCategory = Category::factory()->create();

        $response = $this->deleteJson("/api/order-categories/{$existingCategory->id}");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_delete_nonexisting_order_category()
    {
        $this->login(true);

        $response = $this->deleteJson("/api/order-categories/123456789");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delete_order_category_access()
    {
        $this->login();

        $existingCategory = Category::factory()->create();

        $response = $this->deleteJson("/api/order-categories/{$existingCategory->id}");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
