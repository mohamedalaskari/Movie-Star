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
            'description' => fake()->text(),
            'episode_url' => fake()->url(),
            'season_id' => Season::all()->random()->id,

        ];
    }
}
