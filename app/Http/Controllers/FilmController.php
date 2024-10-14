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

    public function getFilmsByRange($start, $end)
    {
        // Validasi input
        if ($start < 0 || $end < $start) {
            return response()->json(['error' => 'Invalid range'], 400);
        }

        // Ambil data film dalam rentang tertentu
        $films = Film::skip($start - 1)->take($end - $start + 1)->get();

        // Kembalikan data film
        return response()->json($films);
    }

    // public function searchFilmsByTitle(Request $request, $start, $end)
    // {
    //     // Ambil parameter title dari request
    //     $title = $request->input('title');

    //     // Buat query untuk mencari film berdasarkan title
    //     $query = Film::query();

    //     if ($title) {
    //         $query->where('title', 'like', '%' . $title . '%');
    //     }

    //     // Eksekusi query dan ambil hasilnya
    //     $films = $query->skip($start - 1)->take($end - $start + 1)->get();

    //     // Kembalikan data film
    //     return response()->json($films);
    // }

    public function searchFilmsByTitle(Request $request, $start, $end)
    {
        // Ambil parameter title dan filterData dari request
        $title = $request->input('title');
        $filterData = $request->input('filterData');
        Log::info($filterData);
    
        // Validasi input
        if ($start < 0 || $end < $start) {
            return response()->json(['error' => 'Invalid range'], 400);
        }
    
        // Buat query untuk mencari film berdasarkan title
        $query = Film::query();
    
        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }
    
        // Tambahkan logika filter tambahan berdasarkan filterData jika tidak kosong
        if (!empty($filterData)) {
            if (isset($filterData[1]) && !empty($filterData[1])) {
                // $query->where('genre', $filterData[1]);
                $query->join('films_genres', 'films.id', '=', 'films_genres.film_id')
                    ->join('genres', 'films_genres.genre_id', '=', 'genres.id')
                    ->whereRaw('LOWER(genres.name) = ?', [strtolower($filterData[1])]);
            }

            if (isset($filterData[4]) && !empty($filterData[4])) {
                $query->join('countries', 'films.country_id', '=', 'countries.id')
                    ->whereRaw('LOWER(countries.name) = ?', [strtolower($filterData[4])]);
            }

            if (isset($filterData[2]) && !empty($filterData[2])) {
                $query->where('rating', intval($filterData[2]));
            }

            if (isset($filterData[0]) && !empty($filterData[0])) {
                $query->where('status', $filterData[0]);
            }

            if (isset($filterData[3]) && !empty($filterData[3])) {
                $query->where('release_date', intval($filterData[3]));
            }
        }
    
        // Ambil data film dalam rentang tertentu
        $films = $query->skip($start - 1)->take($end - $start + 1)->get();
    
        // Kembalikan data film
        return response()->json($films);
    }

    public function getFilmById($id)
    {
        // Ambil data film berdasarkan id
        $film = Film::find($id);

        // Validasi data film
        if (!$film) {
            return response()->json(['error' => 'Film not found'], 404);
        }

        // Kembalikan data film
        return response()->json($film);
    }
}