<?php

namespace App\Http\Controllers;

use App\Models\Trending;
use Illuminate\Http\Request;

class TrendingController extends Controller
{
    //
    public function getAllTrending()
    {
        // Ambil semua data trending
        $trendings = Trending::join('films', 'trendings.film_id', '=', 'films.id')
                             ->select('films.*')
                             ->get();

        // Kembalikan hanya data trending
        return response()->json($trendings);
    }
}
