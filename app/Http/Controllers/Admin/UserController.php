<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tunnel;
use App\Models\Token;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function updatePlan(Request $request, $id)
    {
        $request->validate([
            'plan' => 'required|in:free,pro',
        ]);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $user->plan = $request->plan;
        $user->save();

        return response()->json(['success' => true, 'plan' => $request->plan]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        // User ke tunnels aur tokens bhi delete karo
        Tunnel::where('user_id', (string) $user->id)->delete();
        Token::where('user_id', (string) $user->id)->delete();
        $user->delete();

        return response()->json(['success' => true]);
    }
}
