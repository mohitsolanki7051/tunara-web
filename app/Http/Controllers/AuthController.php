<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    public function showOtpVerify()
    {
        if (!session('pending_user')) {
            return redirect()->route('register');
        }
        return view('auth.otp-verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|string|size:6']);

        $pending = session('pending_user');
        if (!$pending) {
            return redirect()->route('register');
        }

        $otpRecord = \App\Models\OtpVerification::where('email', $pending['email'])
            ->where('verified', false)
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP. Please try again.']);
        }

        if (now()->isAfter($otpRecord->expires_at)) {
            $otpRecord->delete();
            return back()->withErrors(['otp' => 'OTP has expired. Please register again.']);
        }

        if (!\Illuminate\Support\Facades\Hash::check($request->otp, $otpRecord->otp)) {
            return back()->withErrors(['otp' => 'Incorrect OTP. Please try again.']);
        }


        $user = \App\Models\User::create([
            'name'     => $pending['name'],
            'email'    => $pending['email'],
            'password' => $pending['password'],
            'plan'     => 'free',
        ]);


        $otpRecord->delete();
        session()->forget('pending_user');


        \App\Models\Token::create([
            'user_id' => (string) $user->id,
            'token'   => \Illuminate\Support\Str::random(32),
        ]);

     
        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function resendOtp(Request $request)
    {
        $pending = session('pending_user');
        if (!$pending) {
            return redirect()->route('register');
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        \App\Models\OtpVerification::where('email', $pending['email'])->delete();
        \App\Models\OtpVerification::create([
            'email'      => $pending['email'],
            'otp'        => bcrypt($otp),
            'expires_at' => now()->addMinutes(10),
            'verified'   => false,
        ]);

        \App\Helpers\BrevoMail::send(
            $pending['email'],
            $pending['name'],
            'Your Tunara Verification Code',
            view('emails.otp', ['otp' => $otp, 'userName' => $pending['name']])->render()
        );

        return back()->with('resent', 'Verification code resent successfully!');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);


        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);


        \App\Models\OtpVerification::where('email', $request->email)->delete();


        \App\Models\OtpVerification::create([
            'email'      => $request->email,
            'otp'        => bcrypt($otp),
            'expires_at' => now()->addMinutes(10),
            'verified'   => false,
        ]);

        session([
            'pending_user' => [
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
            ]
        ]);

        \App\Helpers\BrevoMail::send(
            $request->email,
            $request->name,
            'Your Tunara Verification Code',
            view('emails.otp', ['otp' => $otp, 'userName' => $request->name])->render()
        );

        return redirect()->route('otp.verify');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
