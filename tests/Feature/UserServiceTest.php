<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;

use Facades\App\Contracts\Mailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    Use RefreshDatabase;
    public function test_user_registration_sends_welcome_email(): void
    {
        Mailer::shouldReceive('sendWelcomeEmail')
            ->once()
            ->with('user@example.com');

        $userService = new UserService();
        $userService->registerUser('user@example.com');
    }

    public function testItCanFetchActiveUser()
    {
        $user = User::factory()->create();

        // mengambil response dari url
        $response = $this->get("/softdel/{$user->email}");

        // pastikan status response 200
        $response->assertStatus(200);

        //pastikan response json sesuai
        $response->assertJson([
            'message' => 'User masih aktif.',
            'email' => $user->email,
        ]);
    }

    public function testCanFetchDeleteUser()
    {
        $user = User::factory()->create();
        // hapus user menggunakan soft deletes
        $user->delete();

        // mengambil response dari url
        $response = $this->get("/softdel/{$user->email}");

        // pastikan status response 200
        $response->assertStatus(200);

        //pastikan response json sesuai
        $response->assertJson([
            'message' => 'User ini telah dihapus.',
            'email' => $user->email,
        ]);
    }

    public function testCustomKeyImplictBindingRoute()
    {
        $user = User::factory()->create();

        $response = $this->get("/custom_key_route/{$user->email}");

        // pastikan status response 200
        $response->assertStatus(200);

        // pastikan mendapatkan response json sesuai format yang ditentukan
        $response->assertJson([
            'message' => 'User active.',
            'nama' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testCustomKeyImplictBindingRouteSoftDeletes()
    {
        $user = User::factory()->create();
        $user->delete();

        $response = $this->get("/custom_key_route/{$user->email}");

        // pastikan status response 200
        $response->assertStatus(200);

        // pastikan mendapatkan response json sesuai format yang ditentukan
        $response->assertJson([
            'message' => 'User telah dihapus.',
            'nama' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testCustomKeyImplictBindingController()
    {
        $user = User::factory()->create();

        $response = $this->get("/custom_key_controller/{$user->email}");

        // pastikan status response 200
        $response->assertStatus(200);

        // pastikan mendapatkan response json sesuai format yang ditentukan
        $response->assertJson([
            'message' => 'User active.',
            'nama' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testCustomKeyImplictBindingControllerSoftDeletes()
    {
        $user = User::factory()->create();
        $user->delete();

        $response = $this->get("/custom_key_controller/{$user->email}");

        // pastikan status response 200
        $response->assertStatus(200);

        // pastikan mendapatkan response json sesuai format yang ditentukan
        $response->assertJson([
            'message' => 'User telah dihapus.',
            'nama' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testCustomKeyImplictBindinggetRouteKeyName()
    {
        $user = User::factory()->create();

        $response = $this->get("/custom_key_controller/{$user->email}");

        // pastikan status response 200
        $response->assertStatus(200);

        // pastikan mendapatkan response json sesuai format yang ditentukan
        $response->assertJson([
            'message' => 'User active.',
            'nama' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testCustomKeyImplictBindinggetRouteKeyNameSoftDeletes()
    {
        $user = User::factory()->create();
        $user->delete();

        $response = $this->get("/custom_key_controller/{$user->email}");

        // pastikan status response 200
        $response->assertStatus(200);

        // pastikan mendapatkan response json sesuai format yang ditentukan
        $response->assertJson([
            'message' => 'User telah dihapus.',
            'nama' => $user->name,
            'email' => $user->email,
        ]);
    }
}
