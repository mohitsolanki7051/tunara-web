<?php

namespace App\Http\Controllers;

use App\Models\RequestLog;
use App\Models\Tunnel;
use App\Models\User;
use App\Models\PlanSetting;
use Illuminate\Http\Request;

class RequestLogController extends Controller
{
    public function log(Request $request)
    {
        $tunnelId = $request->tunnel_id;
        $today    = now()->toDateString();

        // Tunnel find karo
        $tunnel = Tunnel::where('tunnel_id', $tunnelId)->first();
        if (!$tunnel) {
            return response()->json(['success' => false, 'message' => 'Tunnel not found.'], 404);
        }

        // User aur plan find karo
        $user        = User::find($tunnel->user_id);
        $userPlan    = $user->plan ?? 'free';
        $planSetting = PlanSetting::where('plan', $userPlan)->first();
        $maxRequests = $planSetting ? $planSetting->max_requests_per_day : 1000;

        // Aaj ka log find karo ya banao
        $log = RequestLog::where('tunnel_id', $tunnelId)
            ->where('date', $today)
            ->first();

        if (!$log) {
            $log = RequestLog::create([
                'tunnel_id' => $tunnelId,
                'user_id'   => (string) $tunnel->user_id,
                'date'      => $today,
                'count'     => 0,
                'method' => $request->input('method') ?? 'GET',
                'path'   => $request->input('path') ?? '/',
                'status' => $request->input('status') ?? 200,
            ]);
        }

        // Unlimited check (-1 matlab unlimited)
        if ($maxRequests !== -1 && $log->count >= $maxRequests) {
            return response()->json([
                'success' => false,
                'limited' => true,
                'message' => 'Daily request limit reached.',
            ], 429);
        }

        // Count badhao
        $log->count = $log->count + 1;
        $log->save();

        return response()->json(['success' => true, 'count' => $log->count]);
    }

    public function check($tunnelId)
    {
        $today = now()->toDateString();

        $tunnel = Tunnel::where('tunnel_id', $tunnelId)->first();
        if (!$tunnel) {
            return response()->json(['limited' => false]);
        }

        $user        = User::find($tunnel->user_id);
        $userPlan    = $user->plan ?? 'free';
        $planSetting = PlanSetting::where('plan', $userPlan)->first();
        $maxRequests = $planSetting ? $planSetting->max_requests_per_day : 1000;

        if ($maxRequests === -1) {
            return response()->json(['limited' => false]);
        }

        $log   = RequestLog::where('tunnel_id', $tunnelId)->where('date', $today)->first();
        $count = $log ? $log->count : 0;

        return response()->json([
            'limited'     => $count >= $maxRequests,
            'count'       => $count,
            'max'         => $maxRequests,
            'remaining'   => max(0, $maxRequests - $count),
        ]);
    }
    public function summary(Request $request)
{
    $user      = auth()->user();
    $tunnels   = \App\Models\Tunnel::where('user_id', $user->id)->get();
    $tunnelIds = $tunnels->pluck('tunnel_id')->toArray();

    $today = now()->toDateString();
    $last7 = now()->subDays(6)->toDateString();

    // Plan limit
    $userPlan    = $user->plan ?? 'free';
    $planSetting = \App\Models\PlanSetting::where('plan', $userPlan)->first();
    $maxRequests = $planSetting ? (int) $planSetting->max_requests_per_day : 1000;

    // Aaj ki total requests (sabhi tunnels ka sum)
    $todayLogs   = RequestLog::whereIn('tunnel_id', $tunnelIds)->where('date', $today)->get();
    $todayTotal  = $todayLogs->sum('count');

    // Last 7 days — har din ka total
    $weeklyLogs = RequestLog::whereIn('tunnel_id', $tunnelIds)
        ->where('date', '>=', $last7)
        ->get()
        ->groupBy('date')
        ->map(fn($group) => $group->sum('count'));

    // Last 7 days fill karo — agar kisi din data nahi toh 0
    $weekly = [];
    for ($i = 6; $i >= 0; $i--) {
        $date          = now()->subDays($i)->toDateString();
        $weekly[$date] = $weeklyLogs[$date] ?? 0;
    }

    // Per tunnel breakdown (aaj ka)
    $perTunnel = $tunnels->map(function ($t) use ($today) {
        $log = RequestLog::where('tunnel_id', $t->tunnel_id)
            ->where('date', $today)
            ->first();
        return [
            'tunnel_id' => $t->tunnel_id,
            'local_url' => $t->local_url,
            'today'     => $log ? (int) $log->count : 0,
        ];
    });

    return response()->json([
        'today_total'  => $todayTotal,
        'max_requests' => $maxRequests === -1 ? null : $maxRequests,
        'remaining'    => $maxRequests === -1 ? null : max(0, $maxRequests - $todayTotal),
        'weekly'       => $weekly,
        'per_tunnel'   => $perTunnel,
        'plan'         => $userPlan,
    ]);
}
}
