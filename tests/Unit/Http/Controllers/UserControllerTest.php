<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_user_data_signed()
    {
        $this->login();

        $userResponse = $this->getJson("/api/user");
        $userResponse->assertStatus(Response::HTTP_OK);
    }

    public function test_get_user_data_unsigned()
    {
        $userResponse = $this->getJson("/api/user");
        $userResponse->assertUnauthorized();
    }

    public function test_update_user_profile_correct_data()
    {
        $this->login();

        $data = [
            "email" => "newemail@localhost",
            "firstname" => "New FirstName",
            "lastname" => "New LastName",
        ];

        $response = $this->postJson("/api/user/update-profile", $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_update_user_profile_incorrect_data()
    {
        $this->login();

        $data = [
            "firstname" => "New FirstName",
            "lastname" => "New LastName",
        ];

        $response = $this->postJson("/api/user/update-profile", $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_index_users()
    {
        $this->login();

        User::factory(4)->create();

        $response = $this->getJson("/api/users");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_show_user()
    {
        $this->login();

        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_user_correct_data()
    {
        $this->login();

        $data = [
            "email" => "testUser@localhost",
            "firstname" => "firstname",
            "lastname" => "lastname",
            "password" => "password",
            "password_confirmation" => "password",
            "is_admin" => rand(0, 1),
        ];
        $response = $this->postJson("/api/users", $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_user_incorrect_data()
    {
        $this->login();

        $data = [
            "email" => "testUser@localhost",
            "password" => "password",
        ];
        $response = $this->postJson("/api/users", $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_update_user_correct_data()
    {
        $this->login();

        $existingUser = User::factory()->unverified()->withoutRememberToken()->create();

        $data = [
            "email" => $existingUser->email,
            "firstname" => "FirstName New",
            "lastname" => "LastName New",
            "password" => "password_new",
            "password_confirmation" => "password_new",
            "is_admin" => false,
        ];
        $response = $this->putJson("/api/users/{$existingUser->id}", $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_update_user_incorrect_data()
    {
        $this->login();

        $existingUser = User::factory()->unverified()->withoutRememberToken()->create();

        $data = [
            "email" => $existingUser->email,
            "firstname" => "FirstName New",
            "lastname" => "LastName New",
            "password" => "password_new",
            "is_admin" => false,
        ];
        $response = $this->putJson("/api/users/{$existingUser->id}", $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_delete_existing_user()
    {
        $this->login();

        $existingUser = User::factory()->unverified()->withoutRememberToken()->create();

        $response = $this->deleteJson("/api/users/{$existingUser->id}");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_delete_nonexisting_user()
    {
        $this->login();

        $response = $this->deleteJson("/api/users/123456789");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
