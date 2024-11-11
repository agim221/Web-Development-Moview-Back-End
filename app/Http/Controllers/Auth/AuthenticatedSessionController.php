<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        
        $request->session()->regenerate();

        // Ambil pengguna yang sedang diautentikasi
        $user = Auth::user();

        if ($user->is_banned) {
            Auth::logout();

            return response()->json([
                'message' => 'User is banned',
            ], 403);
        }

        return response()->json([
            'message' => 'Authenticated',
            'role' => $user->role,
            'remember_token' => $user->remember_token,
        ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
