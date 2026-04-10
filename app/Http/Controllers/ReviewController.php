<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:60',
            'role' => 'nullable|string|max:60',
            'rating' => 'required|integer|min:1|max:5',
            'text' => 'required|string|min:10|max:500',
        ]);

        Review::create([
            'name' => $request->name,
            'role' => $request->role ?? '',
            'rating' => $request->rating,
            'text' => $request->text,
            'is_approved' => false,
            'show_on_landing' => false,
        ]);

        return back()->with('review_success', 'Thank you! Your review has been submitted for approval.');
    }
}
