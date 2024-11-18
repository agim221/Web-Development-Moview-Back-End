<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bookmark;

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
        $bookmarks = $user->bookmarks()->with('film')->take(10)->get()->pluck('film');

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
            'remember_token' => 'required|exists:users,remember_token',
            'film_id' => 'required|exists:films,id',
        ]);

        $user = User::where('remember_token', $request->remember_token)->firstOrFail();
        $bookmark = new Bookmark([
            'user_id' => $user->id,
            'film_id' => $request->film_id,
        ]);
        $bookmark->save();

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
            'remember_token' => 'required|exists:users,remember_token',
            'film_id' => 'required|exists:films,id',
        ]);

        $user = User::where('remember_token', $request->remember_token)->firstOrFail();
        $bookmark = Bookmark::findOrFail($id);
        $bookmark->update([
            'user_id' => $user->id,
            'film_id' => $request->film_id,
        ]);

        return response()->json($bookmark);
    }

    public function destroy($id)
    {
        $bookmark = Bookmark::findOrFail($id);
        $bookmark->delete();

        return response()->json(null, 204);
    }

    public function checkBookmark(Request $request)
    {
    $request->validate([
        'remember_token' => 'required|exists:users,remember_token',
        'film_id' => 'required|exists:films,id',
    ]);

    $user = User::where('remember_token', $request->remember_token)->firstOrFail();
    $exists = Bookmark::where('user_id', $user->id)
                      ->where('film_id', $request->film_id)
                      ->exists();

    return response()->json(['exists' => $exists]);
    }

    public function remove(Request $request)
{
    $request->validate([
        'remember_token' => 'required|exists:users,remember_token',
        'film_id' => 'required|exists:films,id',
    ]);

    $user = User::where('remember_token', $request->remember_token)->firstOrFail();
    $bookmark = Bookmark::where('user_id', $user->id)
                        ->where('film_id', $request->film_id)
                        ->first();

    if ($bookmark) {
        $bookmark->delete();
        return response()->json(['message' => 'Bookmark removed'], 200);
    }

    return response()->json(['error' => 'Bookmark not found'], 404);
}
}