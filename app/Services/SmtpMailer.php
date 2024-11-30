<?php

namespace App\Services;

use App\Contracts\Mailer;

class SmtpMailer implements Mailer
{
    public function sendWelcomeEmail(string $email): void
    {
        logger("Email selamat datang dikirim ke : $email");
    }
}
