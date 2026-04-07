<?php

namespace App\Http\Controllers;

use App\Models\PlanSetting;

class LandingController extends Controller
{
    public function index()
    {
        $free = PlanSetting::where('plan', 'free')->first();
        $pro  = PlanSetting::where('plan', 'pro')->first();
        return view('landing', compact('free', 'pro'));
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
