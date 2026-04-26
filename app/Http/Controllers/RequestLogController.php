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


        $tunnel = Tunnel::where('tunnel_id', $tunnelId)->first();
        if (!$tunnel) {
            return response()->json(['success' => false, 'message' => 'Tunnel not found.'], 404);
        }

        $user        = User::find($tunnel->user_id);
        $userPlan    = $user->plan ?? 'free';
        $planSetting = PlanSetting::where('plan', $userPlan)->first();
        $maxRequests = $planSetting ? $planSetting->max_requests_per_day : 1000;


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


        if ($maxRequests !== -1 && $log->count >= $maxRequests) {
            return response()->json([
                'success' => false,
                'limited' => true,
                'message' => 'Daily request limit reached.',
            ], 429);
        }


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
}
