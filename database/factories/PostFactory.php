<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'caption' => $this->faker->sentence(4),
            // relation with user table
            'user_id' => rand(1,3),

            'like' => $this->faker->randomNumber(3,false),
            'share' => $this->faker->randomNumber(3,false),
            'comment' => $this->faker->randomNumber(3,false),
        ];
    }
}
