<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class ActorController extends Controller
{
    public function getAllActors()
    {
        // Ambil semua data aktor
        $actors = Actor::all();

        // Kembalikan hanya data aktor
        return response()->json($actors);
    }

    public function getActorFilms($id)
    {
        // Ambil aktor berdasarkan ID
        $actor = Actor::find($id);

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

    // public function store(Request $request)
    // {
    //     $actor = new Actor;

    //     $actor->name = $request->name;
    //     $actor->photo_url = $request->photo_url;

    //     $actor->save();
    //     return response()->json($actor);
    // }

    // public function update(Request $request, $id)
    // {
    //     $actor = Actor::find($id);

    //     if (!$actor) {
    //         return response()->json(['message' => 'Actor not found'], 404);
    //     }

    //     $actor->name = $request->name;
    //     $actor->photo_url = $request->photo_url;

    //     $actor->save();
    //     return response()->json($actor);
    // }

    public function destroy($id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json(['message' => 'Actor not found'], 404);
        }

        $actor->delete();
        return response()->json(null, 204);
    }

    // public function store(Request $request)
    // {
    //     // Validasi data
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $actor = new Actor();
    //     $actor->name = $request->name;

    //     if ($request->hasFile('photo')) {
    //         // Simpan foto di folder public/uploads/actors
    //         $path = $request->file('photo')->store('uploads/actors', 'public');
    //         // Simpan URL foto
    //         $actor->photo_url = asset('storage/' . $path);
    //     }

    //     $actor->save();

    //     return response()->json($actor, 201);
    // }

    public function store(Request $request)
{
    // Validasi data
    $request->validate([
        'name' => 'required|string|max:255',
        'photo' => 'nullable|string', // Validasi foto sebagai string karena berupa Base64
    ]);

    $actor = new Actor();
    $actor->name = $request->name;

    if ($request->photo) {
        // Mendekode foto dari Base64
        $photoData = $request->photo;
        // Memeriksa apakah data foto berupa Base64
        if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $type)) {
            $photoData = substr($photoData, strpos($photoData, ',') + 1);
            $type = strtolower($type[1]); // Mendapatkan tipe file (jpg, png, dll.)

            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                return response()->json(['error' => 'Tipe file tidak valid.'], 400);
            }

            $photoData = base64_decode($photoData);

            // Menyimpan file gambar di folder public/uploads/actors
            $fileName = 'actor_' . time() . '.' . $type;
            $path = public_path('storage/uploads/actors/' . $fileName);

            file_put_contents($path, $photoData);

            // Menyimpan URL foto
            $actor->photo_url = asset('storage/uploads/actors/' . $fileName);
        } else {
            return response()->json(['error' => 'Format foto tidak valid.'], 400);
        }
    }

    $actor->save();

    return response()->json($actor, 201);
}


// public function update(Request $request, $id)
// {
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

//     Log::info($request->all());

//     $actor = Actor::find($id);


//     if (!$actor) {
//         return response()->json(['message' => 'Actor not found'], 404);
//     }

//     $actor->name = $request->input('name'); // Pastikan mengambil 'name' dengan benar


//     if ($request->hasFile('photo')) {
//         // Hapus foto lama jika ada
//         if ($actor->photo_url) {
//             $oldPath = str_replace(asset('storage/'), '', $actor->photo_url);
//             Storage::disk('public')->delete($oldPath);
//         }

//         // Simpan foto baru
//         $path = $request->file('photo')->store('uploads/actors', 'public');
//         $actor->photo_url = asset('storage/' . $path);
//     }

//     $actor->save();

//     return response()->json($actor, 200);
// }

public function update(Request $request, $id)
{
    // Validasi data
    $request->validate([
        'name' => 'required|string|max:255',
        'photo' => 'nullable|string', // Menggunakan string karena foto dikirim dalam format Base64
    ]);

    Log::info($request->all());

    $actor = Actor::find($id);

    if (!$actor) {
        return response()->json(['message' => 'Actor not found'], 404);
    }

    // Perbarui nama aktor
    $actor->name = $request->input('name');

    // Perbarui foto jika ada data foto baru
    if ($request->photo) {
        // Hapus foto lama jika ada
        if ($actor->photo_url) {
            $oldPath = str_replace(asset('storage/'), '', $actor->photo_url);
            Storage::disk('public')->delete($oldPath);
        }

        // Mendekode Base64 dan menyimpan foto baru
        $photoData = $request->photo;
        if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $type)) {
            $photoData = substr($photoData, strpos($photoData, ',') + 1);
            $type = strtolower($type[1]);

            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                return response()->json(['error' => 'Tipe file tidak valid.'], 400);
            }

            $photoData = base64_decode($photoData);

            // Simpan file gambar di folder public/uploads/actors
            $fileName = 'actor_' . time() . '.' . $type;
            $path = public_path('storage/uploads/actors/' . $fileName);

            file_put_contents($path, $photoData);

            // Simpan URL foto baru
            $actor->photo_url = asset('storage/uploads/actors/' . $fileName);
        } else {
            return response()->json(['error' => 'Format foto tidak valid.'], 400);
        }
    }

    $actor->save();

    return response()->json($actor, 200);
}

}
