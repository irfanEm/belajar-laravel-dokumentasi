<?php

namespace App\Services;

use Facades\App\Contracts\Mailer;

class UserService
{
    public function registerUser(string $email): void
    {
        logger("User terdaftar dengan email: $email");

        Mailer::sendWelcomeEmail($email);
    }
}
