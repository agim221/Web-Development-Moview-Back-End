<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    public function register(Request $request)
    {
        // Ambil parameter nama dan email dari request
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        
        Log::info($username);
        Log::info($email);
        Log::info($password);

        if (empty($username) || empty($email) || empty($password)) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        // Buat user baru
        $user = new User;
        $user->username = $username;
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->save();

        // Kembalikan data user
        return response()->json($user);
    }

    public function login(Request $request)
    {
        // Ambil parameter email dan password dari request
        $username = $request->input('username');
        $password = $request->input('password');

        // Cari user berdasarkan email
        $user = User::where('username', $username)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Jika password tidak sesuai
        if (!password_verify($password, $user->password)) {
            return response()->json(['error' => 'Invalid password'], 401);
        }

        // Kembalikan data user
        return response()->json($user);
    }

    public function getRole(Request $request)
    {
        // Ambil parameter email dari request
        $remember_token = $request->input('remember_token');
        
        // Cari user berdasarkan remember_token
        $user = User::where('remember_token', $remember_token)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Kembalikan data user
        return response()->json($user->role);
    }

    public function index()
    {
        return User::all();
    }

    public function searchUser(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('username', 'LIKE', "%{$query}%")
                     ->orWhere('email', 'LIKE', "%{$query}%")
                     ->get();
        return response()->json($users);
    }

    public function blockUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->is_banned = true;
        $user->save();

        return response()->json($user);
    }

    public function unblockUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->is_banned = false;
        $user->save();

        return response()->json($user);
    }

    public function getDetailAccount(Request $request)
    {
        $remember_token = $request->input('remember_token');

        $user = User::where('remember_token', $remember_token)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // return username and email
        return response()->json($user->only(['username', 'email']));
    }


    /**
     * Change password
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $remember_token = $request->input('remember_token');
        $current_password = $request->input('current_password');
        $new_password = $request->input('new_password');

        $user = User::where('remember_token', $remember_token)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (!password_verify($current_password, $user->password)) {
            return response()->json(['message' => 'Invalid password'], 401);
        }

        $user->password = bcrypt($new_password);
        $user->save();

        return response()->json($user);
    }
}
