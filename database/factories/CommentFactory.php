<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Film;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'film_id' => Film::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'comment' => $this->faker->sentence(10),
            'rating' => $this->faker->numberBetween(1, 5),
            'created_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
