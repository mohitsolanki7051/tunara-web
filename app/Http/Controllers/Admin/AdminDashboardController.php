<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tunnel;
use App\Models\PlanSetting;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers    = User::count();
        $freeUsers     = User::where('plan', 'free')->orWhereNull('plan')->count();
        $proUsers      = User::where('plan', 'pro')->count();
        $totalTunnels  = Tunnel::count();

        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();

        $plans = PlanSetting::all()->keyBy('plan');

        return view('admin.dashboard', compact(
            'totalUsers',
            'freeUsers',
            'proUsers',
            'totalTunnels',
            'recentUsers',
            'plans'
        ));
    }
}
