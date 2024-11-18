<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Film;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function addComment(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'film_id' => 'required|integer',
            'remember_token' => 'required|string',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Ambil parameter film_id, remember_token, comment, dan rating dari request
        $film_id = $validatedData['film_id'];
        $remember_token = $validatedData['remember_token'];
        $commentText = $validatedData['comment'];
        $rating = $validatedData['rating'];

        // Cari user_id berdasarkan remember_token
        $user = User::where('remember_token', $remember_token)->first();

        // Validasi jika user tidak ditemukan
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user_id = $user->id;

        // Validasi jika user sudah menambah komentar
        $existingComment = Comment::where('film_id', $film_id)->where('user_id', $user_id)->first();
        if ($existingComment) {
            return response()->json(['error' => 'User already commented'], 400);
        }

        // Buat data komentar baru
        $newComment = new Comment();
        $newComment->film_id = $film_id;
        $newComment->user_id = $user_id;
        $newComment->comment = $commentText;
        $newComment->rating = $rating;
        $newComment->created_at = now();
        $newComment->updated_at = now();

        // Simpan data komentar
        $newComment->save();

        // Perbarui rating film
        $film = Film::findOrFail($film_id);
        $film->updateRating();

        // Kembalikan data komentar yang baru saja dibuat
        return response()->json($newComment);
    }

    public function index()
    {
        // Mengambil semua data comments dengan join ke tabel users dan dramas
        $comments = Comment::with(['user', 'films'])->get();



        return response()->json($comments);
    }

    public function destroy($id)
    {
        // Cari data komentar berdasarkan id
        $comment = Comment::find($id);

        // Jika data komentar tidak ditemukan
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        // Simpan referensi film sebelum menghapus komentar
        $film = $comment->film;

        // Hapus data komentar
        $comment->delete();

        // Perbarui rating film
        if ($film) {
            $film->updateRating();
        }

        // Kembalikan response kosong dengan status code 204
        return response()->json(null, 204);
    }

    public function searchComment(Request $request)
    {
        $query = $request->input('query');
        $comments = Comment::where('comment', 'LIKE', "%{$query}%")->get();
        return response()->json($comments);
    }

    public function getUnapprovedComments()
    {
        $comments = Comment::where('is_approved', false)->with('user', 'films')->get();
        return response()->json($comments);
    }

    public function getApprovedComments()
    {
        $comments = Comment::where('is_approved', true)->with('user', 'films')->get();  
        return response()->json($comments);
    }

    public function approveComment($id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->is_approved = true;
        $comment->save();

        return response()->json($comment);
    }
}