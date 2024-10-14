<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class BookmarkController extends Controller
{
    public function getFilmBookmark(Request $request, $token)
    {
        // Cari pengguna berdasarkan token
        $user = User::where('remember_token', $token)->first();

        // Jika pengguna tidak ditemukan, kembalikan respons error
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Ambil bookmark dari pengguna tersebut, batasi hingga 20
        $bookmarks = $user->bookmarks()->with('film')->take(20)->get()->pluck('film');

        // Kembalikan hasil dalam bentuk JSON
        return response()->json($bookmarks);
    }

    public function getFilmBookmarkByRange(Request $request, $start, $end)
    {
        $user = $request->user();
        $bookmarks = $user->bookmarks()->with('film')->skip($start)->take($end - $start)->get();
        return response()->json($bookmarks);
    }
}