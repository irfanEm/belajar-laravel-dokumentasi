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

    public function test_route_model_binding_user_notfound()
    {
        $response = $this->get('/user/998');

        //cek apakah response sukses
        $response->assertStatus(404);
    }

    public function test_implict_binding_controller_found()
    {
        $user = User::factory()->create([
            'name' => 'Irfan M',
            'email' => 'iem97@test.com'
        ]);

        $response= $this->get('/imbin/' . $user->id);

        // cek status response sukses
        $response->assertStatus(200);

        // cek apakah data valid
        $response->assertSee('Irfan M');
        $response->assertSee('iem97@test.com');
    }
}
