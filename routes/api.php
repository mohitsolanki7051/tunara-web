<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Token;
use App\Http\Controllers\RequestLogController;
use App\Http\Controllers\TunnelController;

Route::post('/verify-token', function (Request $request) {
    $token = Token::where('token', $request->token)->first();
    return response()->json(['valid' => (bool) $token]);
});
Route::post('/request/log', [RequestLogController::class, 'log']);
Route::get('/request/check/{tunnelId}', [RequestLogController::class, 'check']);

// Password verify
Route::post('/tunnel/verify-password', function (Request $request) {
    $tunnel = \App\Models\Tunnel::where('tunnel_id', $request->tunnel_id)->first();
    if (!$tunnel) return response()->json(['valid' => false]);
    if (!$tunnel->is_protected) return response()->json(['valid' => true]);
    $valid = \Illuminate\Support\Facades\Hash::check($request->password, $tunnel->password);
    return response()->json(['valid' => $valid]);
});
