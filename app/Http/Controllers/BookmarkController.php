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

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'film_id' => 'required|exists:films,id',
        ]);

        $bookmark = Bookmark::create($request->all());

        return response()->json($bookmark, 201);
    }

    public function show($id)
    {
        $bookmark = Bookmark::with('film')->findOrFail($id);
        return response()->json($bookmark);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'film_id' => 'required|exists:films,id',
        ]);

        $bookmark = Bookmark::findOrFail($id);
        $bookmark->update($request->all());

        return response()->json($bookmark);
    }

    public function destroy($id)
    {
        $bookmark = Bookmark::findOrFail($id);
        $bookmark->delete();

        return response()->json(null, 204);
    }
}