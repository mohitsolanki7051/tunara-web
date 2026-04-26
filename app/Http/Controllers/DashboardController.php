<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\Tunnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
public function index()
{
    $user = Auth::user();

    $token = Token::where('user_id', $user->id)->first();

    if (!$token) {
        $token = Token::create([
            'user_id' => $user->id,
            'token'   => Str::random(32),
            'name'    => 'Default Token',
        ]);
    }


    $serverConnected = true;
    try {
        Http::timeout(5)->post(env('RAILWAY_SERVER_URL') . '/api/token/store', [
            'token'  => $token->token,
            'userId' => (string) $user->id,
        ]);
    } catch (\Exception $e) {

        $serverConnected = false;
    }

    $tunnels = Tunnel::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $userPlan    = $user->plan ?? 'free';
    $planSetting = \App\Models\PlanSetting::where('plan', $userPlan)->first();
    $maxTunnels  = $planSetting ? $planSetting->max_tunnels : 1;

    return view('dashboard', compact('token', 'tunnels', 'userPlan', 'planSetting', 'maxTunnels','serverConnected'));
}
}
