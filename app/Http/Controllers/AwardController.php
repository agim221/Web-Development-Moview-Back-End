<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Award;
use Illuminate\Support\Facades\Log;

class AwardController extends Controller
{
    public function index()
    {
        return Award::all();
    }
    
    public function store(Request $request)
    {
        $award = new Award;
        $award->name = $request->name;
        $award->year = $request->year;
        $award->save();
        return response()->json($award);
    }

    public function update(Request $request, $id)
    {
        $award = Award::find($id);
        $award->name = $request->name;
        $award->year = $request->year;
        $award->save();
        return response()->json($award);
    }

    public function destroy($id)
    {
        $award = Award::find($id);
        if (!$award) {
            return response()->json(['message' => 'Award not found'], 404);
        }
        $award->delete();
        return response()->json(null, 204);
    }

    public function getFilmByAward(Request $request)
    {
        $award = $request->name;
        $awardId = Award::where('name', $award)->first()->id;
        $film = Award::find($awardId)->film->first()->film;
        return response()->json($film);
    }

    public function searchAward(Request $request)
    {
        $query = $request->input('query');
        $awards = Award::where('name', 'LIKE', "%{$query}%")->get();
        return response()->json($awards);
    }
}
