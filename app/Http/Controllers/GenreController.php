<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function getAllGenres()
    {
        // Ambil semua data genre
        $genres = Genre::all();

        // Kembalikan hanya data genre
        return response()->json($genres);
    }
}
