<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{

    // Create
    public function store(Request $request)
    {
        // Validate the request...
        $country = new Country;

        $country->name = $request->name;

        $country->save();
        return response()->json($country);
    }

    //read
    public function index()
    {
        return response()->json(Country::all());
    }

    //update
    public function update(Request $request, $id)
    {
        // Validate the request...
        $country = Country::find($id);
        $country->name = $request->name;

        $country->save();
        return response()->json($country);
    }

    //delete
    public function destroy($id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }
    
        $country->delete();
        return response()->json(null, 204);

//     public function getAllCountries()
//     {
//         // Ambil semua data country
//         $countries = Country::all();

//         // Kembalikan hanya data country
//         return response()->json($countries);
//     }
    }

    public function searchCountry(Request $request)
    {
        $query = $request->input('query');
        $countries = Country::where('name', 'LIKE', "%{$query}%")->get();
        return response()->json($countries);
    }
}