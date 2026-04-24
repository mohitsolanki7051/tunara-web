<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoMail
{
    public static function send(string $toEmail, string $toName, string $subject, string $htmlContent): bool
    {
        $response = Http::withHeaders([
            'accept'       => 'application/json',
            'api-key'      => env('BREVO_API_KEY'),
            'content-type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name'  => env('MAIL_FROM_NAME', 'Tunara'),
                'email' => 'noreply@tunara.online',
            ],
            'to' => [
                ['email' => $toEmail, 'name' => $toName]
            ],
            'subject'     => $subject,
            'htmlContent' => $htmlContent,
        ]);
Log::info('Brevo response: ' . $response->body());
        if (!$response->successful()) {
            Log::error('Brevo mail failed: ' . $response->body());
            return false;
        }

        return true;
    }
}
