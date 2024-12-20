<?php

namespace Database\Factories;

use App\Models\Actor;
use App\Models\Film;
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
        return [
            'film_id' => $this->faker->numberBetween(1, 85),
            'actor_id' => $this->faker->numberBetween(1, 20),
        ];
    }
}
