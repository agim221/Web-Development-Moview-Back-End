<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Award;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Year;
use App\Models\Film;
use App\Models\Actor;
use App\Models\ActorFilm;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\FilmAward;
use App\Models\FilmGenre;
use App\Models\Trending;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Award::factory(10)->create();
        Country::factory(10)->create();
        Genre::factory(4)->create();
        Year::factory(10)->create();
        Film::factory(60)->create();
        Actor::factory(10)->create();
        Award::factory(5)->create();
        Comment::factory(10)->create();
        Trending::factory(5)->create();
        Bookmark::factory(10)->create();
        ActorFilm::factory(10)->create();
        FilmGenre::factory(10)->create();
        FilmAward::factory(10)->create();
    }
}