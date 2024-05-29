<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

abstract class TestCase extends BaseTestCase
{
    public function login(bool $asAdmin = false): User
    {
        $q = User::factory()->unverified()->withoutRememberToken();

        $password = "testing-password";

        $user = ($asAdmin ? $q->asAdmin() : $q)->create([
            "email" => "test@localhost",
            "password" => Hash::make($password),
        ]);

        $loginResponse = $this->postJson("/login", [
            "email" => $user->email,
            "password" => $password,
        ]);

        $loginResponse->assertStatus(Response::HTTP_OK);
        $this->actingAs($user, "sanctum");
        return $user;
    }
}
