<?php

namespace App\Http\Controllers;

use App\Models\RequestLog;
use App\Models\Tunnel;
use App\Models\PlanSetting;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user      = Auth::user();
        $tunnels   = Tunnel::where('user_id', $user->id)->get();
        $tunnelIds = $tunnels->pluck('tunnel_id')->toArray();

        $today = now()->toDateString();
        $last7 = now()->subDays(6)->toDateString();

        $userPlan    = $user->plan ?? 'free';
        $planSetting = PlanSetting::where('plan', $userPlan)->first();
        $maxRequests = $planSetting ? (int) $planSetting->max_requests_per_day : 1000;

        // Aaj ki total
        $todayTotal = RequestLog::whereIn('tunnel_id', $tunnelIds)
            ->where('date', $today)->get()->sum('count');

        // Last 7 days
        $weeklyLogs = RequestLog::whereIn('tunnel_id', $tunnelIds)
            ->where('date', '>=', $last7)->get()
            ->groupBy('date')
            ->map(fn($g) => $g->sum('count'));

        $weekly = [];
        for ($i = 6; $i >= 0; $i--) {
            $date          = now()->subDays($i)->toDateString();
            $weekly[$date] = $weeklyLogs[$date] ?? 0;
        }

        // Per tunnel (aaj)
        $perTunnel = $tunnels->map(function ($t) use ($today) {
            $log = RequestLog::where('tunnel_id', $t->tunnel_id)
                ->where('date', $today)->first();
            return [
                'tunnel_id' => $t->tunnel_id,
                'local_url' => $t->local_url,
                'public_url' => env('CLOUDFLARE_WORKER_URL') . '/t/' . $t->tunnel_id,
                'today'     => $log ? (int) $log->count : 0,
            ];
        });

        // Last 30 days total
        $last30 = RequestLog::whereIn('tunnel_id', $tunnelIds)
            ->where('date', '>=', now()->subDays(29)->toDateString())
            ->get()->sum('count');

        return view('analytics', compact(
            'todayTotal', 'maxRequests', 'weekly',
            'perTunnel', 'userPlan', 'last30'
        ));
    }
}
