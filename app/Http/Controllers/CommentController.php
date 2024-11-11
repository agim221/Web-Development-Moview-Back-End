<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
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

        // Kembalikan data komentar yang baru saja dibuat
        return response()->json($newComment);
    }

    public function index()
    {
        {
            // Mengambil semua data comments dengan join ke tabel users dan dramas
            $comments = Comment::with(['user', 'films'])->get();
    
            // Memformat data yang akan dikirim ke frontend
            $formattedComments = $comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'username' => $comment->user ? $comment->user->username : 'Unknown',
                    'film' => $comment->films ? $comment->films->title : 'Unknown',
                    'rate' => $comment->rating,
                    'comment' => $comment->comment,
                ];
            });
    
            return response()->json($formattedComments);
        }
    }

    public function destroy($id)
    {
        // Cari data komentar berdasarkan id
        $comment = Comment::find($id);

        // Jika data komentar tidak ditemukan
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        // Hapus data komentar
        $comment->delete();

        // Kembalikan response kosong dengan status code 204
        return response()->json(null, 204);
    }

    public function searchComment(Request $request)
    {
        $query = $request->input('query');
        $comments = Comment::where('comment', 'LIKE', "%{$query}%")->get();
        return response()->json($comments);
    }
}
