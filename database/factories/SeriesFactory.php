<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Series>
 */
class SeriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'discription' => fake()->text(),
            'num_of_seasons' => fake()->randomNumber(1),
            'series_name' => fake()->name(),
            'genre_id' => Genre::all()->random()->id,
        ];
    }
}
