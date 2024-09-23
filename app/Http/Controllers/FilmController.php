<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilmController extends Controller
{

    public function getAllFilms()
    {
        // Ambil semua data film
        $films = Film::all();

        // Kembalikan hanya data film
        return response()->json($films);
    }
}