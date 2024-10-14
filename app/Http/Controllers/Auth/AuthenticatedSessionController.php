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
    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request)

    // {
    //     $request->authenticate();
        
    //     $request->session()->regenerate();
        
    //     return response()->json(['message' => 'Authenticated'], 200);
    // }
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        
        $request->session()->regenerate();

        // Ambil pengguna yang sedang diautentikasi
        $user = Auth::user();


        return response()->json([
            'message' => 'Authenticated',
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
