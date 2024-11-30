<?php

namespace App\Contracts;

interface Mailer
{
    public function sendWelcomeEmail(string $email): void;
}
