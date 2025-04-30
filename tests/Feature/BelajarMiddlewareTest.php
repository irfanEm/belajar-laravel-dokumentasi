<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BelajarMiddlewareTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_request_without_security_token()
    {
        $response = $this->get('/global-middleware');

        $response->assertJson([
            "message" => "Akses ditolak, token tidak valid !."
        ])
        ->assertStatus(403);
    }
}
