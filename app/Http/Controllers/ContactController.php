<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // ─── reCAPTCHA VERIFY ───────────────────────────────────────
        $token = $request->input('g-recaptcha-response');

        if (!$token) {
            return back()->withErrors(['captcha' => 'reCAPTCHA verification failed.'])->withInput();
        }

        $response = \Illuminate\Support\Facades\Http::post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret_key'),
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (!($result['success'] ?? false) || ($result['score'] ?? 0) < 0.5) {
            return back()->withErrors(['captcha' => 'Bot detected. Please try again.'])->withInput();
        }
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
            'website' => 'max:0', // honeypot
        ]);

        ContactMessage::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return back()->with('contact_success', 'Your message has been sent! We\'ll get back to you soon.');
    }
}
