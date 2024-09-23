<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    /**
     * Get films by year.
     *
     * @param int $year
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllYears()
    {
        // Ambil semua data tahun
        $years = Year::all();

        // Kembalikan hanya data tahun
        return response()->json($years);
    }

    public function getFilmsByYear($year)
    {
        $year = (int) $year;
        // Cari tahun berdasarkan nilai year
        $yearModel = Year::where('year', $year)->first();

        if (!$yearModel) {
            return response()->json(['message' => 'Year not found'], 404);
        }

        // Ambil film yang terkait dengan tahun tersebut
        $films = $yearModel->films;

        // Kembalikan hanya data film
        return response()->json($films);
    }
}