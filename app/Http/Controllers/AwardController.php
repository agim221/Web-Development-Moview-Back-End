<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Award;

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
}
