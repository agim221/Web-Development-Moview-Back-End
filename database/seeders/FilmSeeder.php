<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Film;
use App\Models\Country;
use App\Models\Year;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 films with random data
        Country::factory(10)->create();
        Year::factory(10)->create();
        Film::factory(60)->create();
    }
}
