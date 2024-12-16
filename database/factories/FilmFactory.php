<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'description' => fake()->text(),
            'story' => fake()->text(),
            'quality' => fake()->name(),
            'year_of_production' => fake()->year(Carbon::now()),
            'top_10' => fake()->boolean(),
            'image' => fake()->randomElement([
                'football-logo-ac-milan.jpg',
                'football-logo-ajax.jpg',
                'football-logo-bayern-munchen.jpg',
                'football-logo-benfica.jpg',
                'football-logo-fc-barcelona.jpg',
                'football-logo-juventus-fc.jpg',
                'football-logo-liverpool.jpg',
                'football-logo-manchester-united.jpg',
                'football-logo-paris-saint-germain.jpg',
                'football-logo-real-madrid.jpg',
            ]),
            'name' => fake()->name(),
            'rate' => fake()->randomFloat(8, 0, 10),
            'film_url' => fake()->url(),
            'genre_id' => Genre::all()->random()->id,
            'country_id' => Country::all()->random()->id,
        ];
    }
}
