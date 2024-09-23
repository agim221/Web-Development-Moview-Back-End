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

    public function getActorActedIn($actorId)
    {
        $actorId = (int) $actorId;
        // Cari aktor berdasarkan nilai actorId
        $actor = Actor::where('id', $actorId)->first();

        if (!$actor) {
            return response()->json(['message' => 'Actor not found'], 404);
        }

        // Ambil film yang diperankan oleh aktor tersebut
        $films = $actor->acted_in->map(function($actorFilm) {
            return $actorFilm->film;
        });
        // Kembalikan hanya data film
        return response()->json($films);
    }
}
