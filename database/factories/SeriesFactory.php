<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Genre;
use App\Models\Series;
use Carbon\Carbon;
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
            'image' => fake()->randomElement([
                'https://www.papadustream.store/storage/public/image/serie/see-saison-2.jpg',
                'https://m.media-amazon.com/images/M/MV5BNGE4NjZkMzYtMjJmNi00MjgzLTlkNDYtN2FhZTc3NDI3MmNlXkEyXkFqcGdeQXVyNTU2Mzk1NTU@._V1_FMjpg_UX600_.jpg',
                'https://static1.srcdn.com/wordpress/wp-content/uploads/2020/05/ragnar-and-rollos-rivalry.jpg',
                'https://th.bing.com/th/id/OIP.KncjQd2IRNRsot2hqkHQUQHaEM?w=1200&h=680&rs=1&pid=ImgDetMain',
                'https://th.bing.com/th/id/OIP.wIlt5R5Q9p-SXLR94VWDXgAAAA?rs=1&pid=ImgDetMain',
                'https://th.bing.com/th/id/OIP.yNL8jUUV77YQ7ExoUDJYswHaDF?w=2560&h=1068&rs=1&pid=ImgDetMain',
                'https://i.pinimg.com/736x/4a/7d/75/4a7d7514c09193fd0e17748eb141f515.jpg',
                'https://www.papadustream.store/storage/public/image/serie/see-saison-3.jpg',
                'https://th.bing.com/th/id/OIP.7eeZFF0kWghVdOweUGfgWQHaJ4?w=1200&h=1600&rs=1&pid=ImgDetMain',
                'https://pics.filmaffinity.com/Kaamelott_First_Installment-126999002-large.jpg',
            ]),
            'story' => fake()->text(),
            'quality' => fake()->name(),
            'year_of_production' => fake()->year(Carbon::now()),
            'top_10' => fake()->boolean(),
            'rate' => fake()->randomFloat(8, 0, 10),
            'num_of_seasons' => fake()->randomNumber(1),
            'series_name' => fake()->name(),
            'genre_id' => Genre::all()->random()->id,
            'country_id' => Country::all()->random()->id,
        ];
    }
}
