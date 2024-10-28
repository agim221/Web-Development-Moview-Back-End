<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actor;

class ActorController extends Controller
{
    public function getAllActors()
    {
        // Ambil semua data aktor
        $actors = Actor::all();

        // Kembalikan hanya data aktor
        return response()->json($actors);
    }
        // Ambil film yang diperankan oleh aktor tersebut
        $films = $actor->acted_in->map(function($actorFilm) {
            return $actorFilm->film;
        });
        // Kembalikan hanya data film
        return response()->json($films);
    }

    public function store(Request $request)
    {
        $actor = new Actor;

        $actor->name = $request->name;
        $actor->photo_url = $request->photo_url;

        $actor->save();
        return response()->json($actor);
    }

    public function update(Request $request, $id)
    {
        $actor = Actor::find($id);
        $actor->name = $request->name;
        $actor->photo_url = $request->photo_url;

        $actor->save();
        return response()->json($actor);
    }

    public function destroy($id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json(['message' => 'Actor not found'], 404);
        }
    
        $actor->delete();
        return response()->json(null, 204);
    }
}
