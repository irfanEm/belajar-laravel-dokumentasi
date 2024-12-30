<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExplicitBindingTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testExplicitBindingRoute()
    {
        $user = User::factory()->create();

        $response = $this->get("/explicit_binding/{$user->email}");

        // pastikan status response 200
        $response->assertStatus(200);

        // Pastikan response json sesuai
        $response->assertJson([
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]
        ]);
    }
}
