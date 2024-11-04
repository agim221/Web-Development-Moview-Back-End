<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Actor;
use App\Models\Comment;
use App\Models\FilmGenre;
use App\Models\ActorFilm;
use App\Models\Year;
use App\Models\Country;
use App\Models\FilmAward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class FilmController extends Controller
{
    public function getAllFilms()
    {
        // Ambil semua data film
        $films = Film::all();

        // Kembalikan hanya data film
        return response()->json($films);
    }

    public function getFilmsByRange($start, $end)
    {
        // Validasi input
        if ($start < 0 || $end < $start) {
            return response()->json(['error' => 'Invalid range'], 400);
        }

        // Ambil data film dalam rentang tertentu
        $films = Film::skip($start - 1)->take($end - $start + 1)->get();

        // Kembalikan data film
        return response()->json($films);
    }

    public function searchFilmsByTitle(Request $request, $start, $end)
    {
        // Ambil parameter title dan filterData dari request
        $title = $request->input('title');
        $filterData = $request->input('filterData');

        // Validasi input
        if ($start < 0 || $end < $start) {
            return response()->json(['error' => 'Invalid range'], 400);
        }
    
        // Buat query untuk mencari film berdasarkan title
        $query = Film::query();
    
        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }
    
        // Tambahkan logika filter tambahan berdasarkan filterData jika tidak kosong
        if (!empty($filterData)) {
            if (isset($filterData[4]) && !empty($filterData[4])) {
                $query->join('films_awards', 'films.id', '=', 'films_awards.film_id')
                    ->join('awards', 'films_awards.award_id', '=', 'awards.id')
                    ->whereRaw('LOWER(awards.name) = ?', [strtolower($filterData[4])]);
            } else {
                if (isset($filterData[0]) && !empty($filterData[0])) {
                    $query->join('films_genres', 'films.id', '=', 'films_genres.film_id')
                        ->join('genres', 'films_genres.genre_id', '=', 'genres.id')
                        ->whereRaw('LOWER(genres.name) = ?', [strtolower($filterData[0])]);
                }
        
                if (isset($filterData[2]) && !empty($filterData[2])) {
                    $query->join('countries', 'films.country_id', '=', 'countries.id')
                        ->whereRaw('LOWER(countries.name) = ?', [strtolower($filterData[2])]);
                }
        
                if (isset($filterData[1]) && !empty($filterData[1])) {
                    $query->where('release_date', intval($filterData[1]));
                }

                // order asc or desc
                if (isset($filterData[3]) && !empty($filterData[3])) {
                    if ($filterData[3] == 'asc') {
                        $query->orderBy('title', 'asc');
                    } else {
                        $query->orderBy('title', 'desc');
                    }
                }
            }
        }
    
        // Ambil data film dalam rentang tertentu
        $films = $query->skip($start - 1)->take($end - $start + 1)->get();
    
        // Kembalikan data film
        return response()->json($films);
    }

    public function getFilmById($id)
    {
        // Ambil data film berdasarkan id
        $film = Film::find($id);

        // Validasi data film
        if (!$film) {
            return response()->json(['error' => 'Film not found'], 404);
        }

        // Kembalikan data film
        return response()->json($film);
    }

    public function searchFilmsByActor(Request $request, $start, $end)
    {
    // Ambil parameter actor_name dan filterData dari request
        $actorName = $request->input('name');
        $filterData = $request->input('filterData');

    // Validasi input
        if ($start < 0 || $end < $start) {
            return response()->json(['error' => 'Invalid range'], 400);
        }

        // Buat query untuk mencari film berdasarkan actor_name
        $query = Film::query();

        if ($actorName) {
            // Join tabel films, actor_film, dan actors
            $query->join('actors_films', 'films.id', '=', 'actors_films.film_id')
                ->join('actors', 'actors_films.actor_id', '=', 'actors.id')
                ->where('actors.name', 'like', '%' . $actorName . '%');
        }

        // Tambahkan logika filter tambahan berdasarkan filterData jika tidak kosong
        if (!empty($filterData)) {
            if (isset($filterData[4]) && !empty($filterData[4])) {
                $query->join('films_awards', 'films.id', '=', 'films_awards.film_id')
                    ->join('awards', 'films_awards.award_id', '=', 'awards.id')
                    ->whereRaw('LOWER(awards.name) = ?', [strtolower($filterData[4])]);
            } else {

                if (isset($filterData[0]) && !empty($filterData[0])) {
                    // $query->where('genre', $filterData[1]);
                    $query->join('films_genres', 'films.id', '=', 'films_genres.film_id')
                    ->join('genres', 'films_genres.genre_id', '=', 'genres.id')
                    ->whereRaw('LOWER(genres.name) = ?', [strtolower($filterData[0])]);
                }
                
                if (isset($filterData[2]) && !empty($filterData[2])) {
                    $query->join('countries', 'films.country_id', '=', 'countries.id')
                    ->whereRaw('LOWER(countries.name) = ?', [strtolower($filterData[2])]);
                }
                if (isset($filterData[1]) && !empty($filterData[1])) {
                    $query->where('release_date', intval($filterData[1]));
                }

                if (isset($filterData[3]) && !empty($filterData[3])) {
                    if ($filterData[3] == 'asc') {
                        $query->orderBy('title', 'asc');
                    } else {
                        $query->orderBy('title', 'desc');
                    }
                }
            }
        }
            
        // Ambil data film dalam rentang tertentu
        $films = $query->skip($start - 1)->take($end - $start + 1)->get();

        // Kembalikan data film
        return response()->json($films);
    }

    public function getFilmActors($filmId)
    {
        // Ambil data aktor yang bermain dalam film tertentu
        $actors = Actor::join('actors_films', 'actors.id', '=', 'actors_films.actor_id')
            ->where('actors_films.film_id', $filmId)
            ->get();

        // Kembalikan data aktor
        return response()->json($actors);
    }

    public function getFilmComments($filmId)
    {
        // Ambil data komentar yang terkait dengan film tertentu
        $comments = Comment::where('film_id', $filmId)->with('user')->get();

        // Kembalikan data komentar
        return response()->json($comments);
    }

    public function autoCompleteByTitle(Request $request) {
        $title = $request->input('title');
    
        // Pastikan title tidak kosong
        if (empty($title)) {
            return response()->json(['error' => 'Title is required'], 400);
        }
    
        // Ubah title menjadi huruf kecil
        $title = strtolower($title);
    
        // Cari film berdasarkan judul yang diubah menjadi huruf kecil dan ambil 5 hasil teratas
        $films = Film::whereRaw('LOWER(title) LIKE ?', ['%' . $title . '%'])->take(5)->get();
    
        // Kembalikan hasil dalam format JSON
        return response()->json($films);
    }

    public function autoCompleteByActor(Request $request) {
        $result = [];
        $name = $request->input('name');
    
        if (empty($name)) {
            return response()->json(['error' => 'Name is required'], 400);
        }
    
        $name = strtolower($name);
    
        $actors = Actor::whereRaw('LOWER(name) LIKE ?', ['%' . $name . '%'])->get();
    
        foreach ($actors as $actor) {
            foreach ($actor->acted_in as $film) {
                $result[] = $film->film;
                if (count($result) >= 5) {
                    return response()->json($result);
                }
            }
        }
    
        return response()->json($result);
    }

    public function getFilmGenres($filmId)
    {
        $genre = FilmGenre::where('film_id', $filmId)->with('genre')->get();

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        return response()->json($genre);
    }

    public function store(Request $request)
    {
        $actors = $request->input('actors', []);
        $genres = $request->input('genres', []);
        $awards = $request->input('awards', []);
    
        if ($request->input('image')) {
            $imageData = $request->input('image');
            // Memeriksa apakah data gambar berupa Base64
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]); // Mendapatkan tipe file (jpg, png, dll.)
                if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return response()->json(['error' => 'Tipe file tidak valid.'], 400);
                }
                $imageData = base64_decode($imageData);
                // Pastikan direktori ada
                $directory = public_path('storage/uploads/films');
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true);
                }
                // Menyimpan file gambar di folder public/storage/uploads/films
                $fileName = 'film_' . time() . '.' . $type;
                $path = $directory . '/' . $fileName;
                file_put_contents($path, $imageData);
                // Menyimpan path gambar
                $imagePath = asset('storage/uploads/films/' . $fileName);
            } else {
                return response()->json(['error' => 'Format gambar tidak valid.'], 400);
            }
        }
    
        // Membuat instance film dan menyimpan data ke database
        $film = new Film();
        $film->title = $request->input('title');
        $film->image = $imagePath ?? null; // Menyimpan path gambar
        $film->description = $request->input('description');
        $film->release_date = $request->input('release_date');
        $film->rating = 5.0;
        $film->country_id = $request->input('country_id');
        $film->status = 1;
        $film->trailer = $request->input('trailer');
        $film->availability = $request->input('availability');
        $film->save(); // Menyimpan film ke database
    
        // Mengambil id film berdasarkan image_path
        $filmId = $film->id;
    
        // Menyimpan data aktor yang bermain dalam film
        foreach ($actors as $actor) {
            $actorFilm = new ActorFilm();
            $actorFilm->actor_id = $actor;
            $actorFilm->film_id = $filmId;
            $actorFilm->save();
        }
    
        // Menyimpan data genre film
        foreach ($genres as $genre) {
            $filmGenre = new FilmGenre();
            $filmGenre->genre_id = $genre;
            $filmGenre->film_id = $filmId;
            $filmGenre->save();
        }
    
        // Menyimpan data penghargaan film
        foreach ($awards as $award) {
            $filmAward = new FilmAward();
            $filmAward->award_id = $award;
            $filmAward->film_id = $filmId;
            $filmAward->save();
        }
    
        return response()->json(['message' => 'Film created successfully!', 'film' => $film], 201);
    }
}