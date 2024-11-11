<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        return response()->json(Genre::all());
    }

    public function store(Request $request)
    {
        $genre = new Genre;

        $genre->name = $request->name;

        $genre->save();
        return response()->json($genre);
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);
        $genre->name = $request->name;

        $genre->save();
        return response()->json($genre);
    }

    public function destroy($id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }
    
        $genre->delete();
        return response()->json(null, 204);
    }

    public function searchGenre(Request $request)
    {
        $query = $request->input('query');
        $genres = Genre::where('name', 'LIKE', "%{$query}%")->get();
        return response()->json($genres);
    }
}
