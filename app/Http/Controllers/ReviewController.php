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
