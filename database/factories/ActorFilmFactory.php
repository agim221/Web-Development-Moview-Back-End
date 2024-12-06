<?php

namespace Database\Factories;

use App\Models\Actor;
use App\Models\Film;
use App\Models\ActorFilm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActorFilm>
 */
class ActorFilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filmId = Film::inRandomOrder()->first()->id;
        $actorId = Actor::inRandomOrder()->first()->id;

        // Ensure unique combination of film_id and actor_id
        while (ActorFilm::where('film_id', $filmId)->where('actor_id', $actorId)->exists()) {
            $filmId = Film::inRandomOrder()->first()->id;
            $actorId = Actor::inRandomOrder()->first()->id;
        }

        return [
            'film_id' => $filmId,
            'actor_id' => $actorId,
        ];
    }
}