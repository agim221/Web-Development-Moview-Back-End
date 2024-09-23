<?php

namespace Database\Factories;

use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Country;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3), // Generate a random sentence with 3 words
            'image' => $this->faker->imageUrl(), // Generate a random image URL
            'description' => $this->faker->paragraph(3), // Generate a random paragraph with 3 sentences
            'release_date' => Year::inRandomOrder()->first()->year, // Generate a random date
            'rating' => $this->faker->randomFloat(1, 1, 10), // Generate a random float between 1 and 10 with 1 decimal
            'country_id' => Country::inRandomOrder()->first()->id, // Generate a random country name
            'status' => $this->faker->randomElement([0, 1]), // Generate a random integer between 0 and 1]),
            'trailer' => $this->faker->url(), // Generate a random URL
            'availability' => $this->faker->randomElement(['netflix', 'prime', 'disney']), // Generate a random element 
        ];
    }
}
