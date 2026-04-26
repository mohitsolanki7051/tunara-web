<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\Tunnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $token = Token::where('user_id', $user->id)->first();
        return view('settings', compact('user', 'token'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id() . ',_id',
        ]);

        $user        = Auth::user();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success_profile', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success_password', 'Password updated successfully!');
    }

    public function regenerateToken(Request $request)
    {
        $user  = Auth::user();
        $token = Token::where('user_id', $user->id)->first();

        $newToken = Str::random(32);

        if ($token) {
            $token->token = $newToken;
            $token->save();
        } else {
            $token = Token::create([
                'user_id' => $user->id,
                'token'   => $newToken,
                'name'    => 'Default Token',
            ]);
        }


        \Http::post(env('RAILWAY_SERVER_URL') . '/api/token/store', [
            'token'  => $newToken,
            'userId' => (string) $user->id,
        ]);

        return back()->with('success_token', 'Token regenerated! Update it in your desktop app.');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'confirm_delete' => 'required|in:DELETE',
        ]);

        $user = Auth::user();


        Tunnel::where('user_id', $user->id)->delete();
        Token::where('user_id', $user->id)->delete();
        $user->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('message', 'Account deleted successfully.');
    }
}
