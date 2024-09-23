<?php

namespace Database\Factories;

use App\Models\Film;
use App\Models\Trending;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trending>
 */
class TrendingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil semua film yang sudah ada di tabel trending
        $existingTrendingIds = Trending::pluck('film_id')->toArray();

        // Ambil film dari tabel films yang belum ada di tabel trending
        $availableFilmIds = Film::whereNotIn('id', $existingTrendingIds)->pluck('id')->toArray();

        // Pilih film secara acak dari daftar yang tersedia
        $filmId = $this->faker->randomElement($availableFilmIds);

        return [
            'film_id' => $filmId,
        ];
    }
}