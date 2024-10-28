<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class CommentController extends Controller
{
    //
    public function addComment(Request $request)
    {
        // Ambil parameter film_id, user_id, comment, dan rating dari request
        $film_id = $request->input('film_id');
        $remember_token = $request->input('remember_token');
        $comment = $request->input('comment');
        $rating = $request->input('rating');
        Log::info($film_id);
        Log::info($remember_token);
        Log::info($comment);
        Log::info($rating);

        // Cari user_id berdasarkan remember_token
        $user_id = User::where('remember_token', $remember_token)->first()->id;
        Log::info($user_id);

        // // validasi jika user sudah menambah komentar
        // $comment = Comment::where('film_id', $film_id)->where('user_id', $user_id)->first();
        // if ($comment) {
        //     return response()->json(['error' => 'User already commented'], 400);
        // }

        // Validasi input
        if (empty($film_id) || empty($user_id) || empty($comment) || empty($rating)) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        // Buat data komentar baru
        $newComment = new Comment();
        $newComment->film_id = $film_id;
        $newComment->user_id = $user_id;
        $newComment->comment = $comment;
        $newComment->rating = $rating;
        $newComment->created_at = now();
        $newComment->updated_at = now();

        // Simpan data komentar
        $newComment->save();

        // Kembalikan data komentar yang baru saja dibuat
        return response()->json($newComment);
    }
}
