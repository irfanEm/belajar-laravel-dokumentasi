<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteModelBindingTest extends TestCase
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

    public function test_route_model_binding_found_user ()
    {
        $user = User::factory()->create([
            'name' => 'Jems',
            'email' => 'jems@cat.com'
        ]);

        $response = $this->get('/user/'.$user->id);

        //cek apakah response sukses
        $response->assertStatus(200);

        // cek apakah data user ada di view
        $response->assertSee($user->name);
        $response->assertSee($user->email);

    }
}
