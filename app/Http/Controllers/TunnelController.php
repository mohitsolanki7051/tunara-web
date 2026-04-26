<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\Tunnel;
use App\Models\PlanSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TunnelController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'local_url' => 'required|url',
            'password'  => 'nullable|string|min:4',
        ]);

        $user     = Auth::user();
        $userPlan = $user->plan ?? 'free';


        $planSetting = PlanSetting::where('plan', $userPlan)->first();
        $maxTunnels  = $planSetting ? $planSetting->max_tunnels : 1;


        $existingCount = Tunnel::where('user_id', $user->id)->count();
        if ($existingCount >= $maxTunnels) {
            return response()->json([
                'success' => false,
                'message' => $userPlan === 'free'
                    ? "Free plan allows only {$maxTunnels} tunnel. Delete existing or upgrade to Pro."
                    : "You have reached your tunnel limit of {$maxTunnels}.",
            ], 403);
        }


        $isProtected = false;
        $password    = null;

        if ($request->filled('password')) {
            if (!$planSetting || !$planSetting->has_password_protection) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password protection is a Pro feature. Please upgrade.',
                ], 403);
            }
            $isProtected = true;
            $password    = Hash::make($request->password);
        }

        $token = Token::where('user_id', $user->id)->first();
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Token not found.'], 404);
        }


        $response = \Http::post(env('RAILWAY_SERVER_URL') . '/api/tunnel/register', [
            'localUrl' => $request->local_url,
            'isProtected' => $isProtected,
        ]);

        if (!$response->successful()) {
            return response()->json(['success' => false, 'message' => 'Failed to register tunnel.'], 500);
        }

        $data = $response->json();

        $tunnel = Tunnel::create([
            'user_id'      => $user->id,
            'token_id'     => $token->id,
            'tunnel_id'    => $data['tunnelId'],
            'local_url'    => $request->local_url,
            'is_active'    => false,
            'is_protected' => $isProtected,
            'password'     => $password,
        ]);
        $port = parse_url($request->local_url, PHP_URL_PORT) ?? 8000;
        return response()->json([
            'success'      => true,
            'tunnel_id'    => $tunnel->tunnel_id,
            'public_url'   => env('CLOUDFLARE_WORKER_URL') . '/t/' . $tunnel->tunnel_id,
            'token'        => $token->token,
            'is_protected' => $isProtected,
            'port'         => $port,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $tunnel = Tunnel::where('tunnel_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $tunnel->delete();

        return response()->json(['success' => true]);
    }
}
