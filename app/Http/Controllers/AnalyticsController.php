<?php

namespace App\Http\Controllers;

use App\Models\RequestLog;
use App\Models\Tunnel;
use App\Models\PlanSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
public function index(Request $request)
{
    $user      = Auth::user();
    $tunnels   = Tunnel::where('user_id', $user->id)->get();
    $tunnelIds = $tunnels->pluck('tunnel_id')->toArray();

    $today    = now()->toDateString();
    $period   = $request->get('period', '7days');

    $userPlan    = $user->plan ?? 'free';
    $planSetting = PlanSetting::where('plan', $userPlan)->first();
    $maxRequests = $planSetting ? (int) $planSetting->max_requests_per_day : 1000;

    // Period based start date
    $days = match($period) {
        '30days' => 30,
        '6months' => 180,
        '1year' => 365,
        default => 7,
    };

    $startDate = now()->subDays($days - 1)->toDateString();

    // Aaj ki total
    $todayTotal = RequestLog::whereIn('tunnel_id', $tunnelIds)
        ->where('date', $today)->get()->sum('count');

    // Period data
    $periodLogs = RequestLog::whereIn('tunnel_id', $tunnelIds)
        ->where('date', '>=', $startDate)->get()
        ->groupBy('date')
        ->map(fn($g) => $g->sum('count'));

    // Fill missing dates with 0
    $chartData = [];
    for ($i = $days - 1; $i >= 0; $i--) {
        $date            = now()->subDays($i)->toDateString();
        $chartData[$date] = $periodLogs[$date] ?? 0;
    }

    // 6months/1year ke liye weekly group karo
    if (in_array($period, ['6months', '1year'])) {
        $grouped = [];
        foreach ($chartData as $date => $count) {
            $week = \Carbon\Carbon::parse($date)->startOfWeek()->toDateString();
            $grouped[$week] = ($grouped[$week] ?? 0) + $count;
        }
        $chartData = $grouped;
    }

    // Per tunnel (aaj)
    $perTunnel = $tunnels->map(function ($t) use ($today) {
        $log = RequestLog::where('tunnel_id', $t->tunnel_id)
            ->where('date', $today)->first();
        return [
            'tunnel_id'  => $t->tunnel_id,
            'local_url'  => $t->local_url,
            'public_url' => env('CLOUDFLARE_WORKER_URL') . '/t/' . $t->tunnel_id,
            'today'      => $log ? (int) $log->count : 0,
        ];
    });

    // Last 30 days total
    $last30 = RequestLog::whereIn('tunnel_id', $tunnelIds)
        ->where('date', '>=', now()->subDays(29)->toDateString())
        ->get()->sum('count');

    // Period total
    $periodTotal = array_sum($chartData);

    return view('analytics', compact(
        'todayTotal', 'maxRequests', 'chartData',
        'perTunnel', 'userPlan', 'last30',
        'period', 'periodTotal', 'days'
    ));
}
}
