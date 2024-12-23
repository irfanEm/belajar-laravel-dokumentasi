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
        $response = $this->get("/softdel/{$user->id}");

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
        $response = $this->get("/softdel/{$user->id}");

        // pastikan status response 200
        $response->assertStatus(200);

        //pastikan response json sesuai
        $response->assertJson([
            'message' => 'User ini telah dihapus.',
            'email' => $user->email,
        ]);
    }
}
