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


}
