<?php

namespace Database\Factories;

use App\Models\Season;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Episode>
 */
class EpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'episode_number' => fake()->randomNumber(2),
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
            'description' => fake()->text(),
            'episode_url' => fake()->url(),
            'season_id' => Season::all()->random()->id,

        ];
    }
}
