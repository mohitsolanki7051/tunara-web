<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function submit(Request $request)
    {

        if (!empty($request->input('website'))) {
            return redirect()->back()->with('review_success', 'Thank you for your review! It will be visible after approval.');
        }
        // ─── reCAPTCHA VERIFY ───────────────────────────────────────
        $token = $request->input('g-recaptcha-response');

        if (!$token) {
            return redirect()->back()
                ->withErrors(['captcha' => 'reCAPTCHA verification failed.'])
                ->withInput();
        }

        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
            . config('services.recaptcha.secret_key')
            . '&response=' . $token
            . '&remoteip=' . $request->ip();

        $result = json_decode(file_get_contents($url), true);

        if (!($result['success'] ?? false) || ($result['score'] ?? 0) < 0.5) {
            return redirect()->back()
                ->withErrors(['captcha' => 'Bot detected. Please try again.'])
                ->withInput();
        }


        $request->validate([
            'name'   => 'required|string|max:60',
             'email'  => 'required|email|max:100',
            'role'   => 'nullable|string|max:60',
            'rating' => 'required|integer|min:1|max:5',
            'text'   => 'required|string|min:10|max:500',
        ]);

        Review::create([
            'name'            => $request->name,
             'email'           => $request->email,
            'role'            => $request->role ?? '',
            'rating'          => $request->rating,
            'text'            => $request->text,
            'is_approved'     => false,
            'show_on_landing' => false,
            'ip'              => $request->ip(),
            'submitted_at'    => now(),
        ]);
        \App\Helpers\BrevoMail::send(
            $request->email,
            $request->name,
            'Thank You for Your Review — Tunara',
            view('emails.review-thankyou', ['userName' => $request->name])->render()
        );
        return redirect()->back()->with('review_success', 'Thank you for your review! It will be visible after approval.');
    }
}
