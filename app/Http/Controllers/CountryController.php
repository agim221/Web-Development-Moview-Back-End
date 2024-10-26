<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function getAllCountries()
    {
        // Ambil semua data country
        $countries = Country::all();

        // Kembalikan hanya data country
        return response()->json($countries);
    }
}
