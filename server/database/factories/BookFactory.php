<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'title'=> fake()->text($maxNbChars = 20),
            'author'=>fake()->name($gender = null),
            'description'=>fake()->sentence($nbWords = 8, $variableNbWords = true),
            'link'=>fake()->url,
            'featured'=>fake()->boolean($chanceOfGettingTrue = 30),
            'category_id'=>Category::pluck('id')->random(),
        ];
    }
}
