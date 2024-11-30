<?php

namespace Tests\Feature;

use App\Services\UserService;
use Facades\App\Contracts\Mailer;

use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public function test_user_registration_sends_welcome_email(): void
    {
        Mailer::shouldReceive('sendWelcomeEmail')
            ->once()
            ->with('user@example.com');

        $userService = new UserService();
        $userService->registerUser('user@example.com');
    }
}
