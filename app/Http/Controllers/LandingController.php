<?php

namespace App\Http\Controllers;

use App\Models\PlanSetting;
use App\Models\Review;
class LandingController extends Controller
{
    public function index()
    {
        $free = PlanSetting::where('plan', 'free')->first();
        $pro  = PlanSetting::where('plan', 'pro')->first();
        $reviews = Review::where('is_approved', true)
                ->where('show_on_landing', true)
                ->orderBy('created_at', 'desc')
                ->get();
        return view('landing', compact('free', 'pro','reviews'));
    }

    public function pricing()
    {
        $free = PlanSetting::where('plan', 'free')->first();
        $pro  = PlanSetting::where('plan', 'pro')->first();
        return view('landing.pricing', compact('free', 'pro'));
    }

    public function download()
    {
        return view('landing.download');
    }
}
