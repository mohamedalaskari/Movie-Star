<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matches>
 */
class MatchesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "match_url" => fake()->url(),
            'stadium' => fake()->name(),
            'team_1' => fake()->name(),
            'team_2' => fake()->name(),
            'team_1_logo' => fake()->randomElement([
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
            'team_2_logo' => fake()->randomElement([
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
            'champion' => fake()->name(),
            'result' => fake()->randomElement([
                '3-6',
                '0-1',
                '0-2',
                '0-5',
                '0-7',
                '1-0',
                '2-0',
                '8-0',
                '2-1',
                '2-4',
                '8-4',
                '1-3',
            ]),
        ];
    }
}
