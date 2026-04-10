<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewAdminController extends Controller
{
    public function index()
    {
        $pending = Review::where('is_approved', false)->orderBy('created_at', 'desc')->get();
        $approved = Review::where('is_approved', true)->orderBy('show_on_landing', 'desc')->orderBy('created_at', 'desc')->get();
        return view('admin.reviews', compact('pending', 'approved'));
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->is_approved = true;
        $review->save();
        return back()->with('success', 'Review approved!');
    }

    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }

    public function toggleLanding($id)
    {
        $review = Review::findOrFail($id);
        $review->show_on_landing = !$review->show_on_landing;
        $review->save();
        return back()->with('success', 'Updated!');
    }
}
