<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ads>
 */
class AdsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'leftside_image' => $this->faker->sentence(),
            'leftside_redirect_url' => $this->faker->sentence(),
            'rightside_image' => $this->faker->sentence(),
            'rightside_redirect_url' => $this->faker->sentence(),
            'banner_image' => $this->faker->sentence(),
            'banner_redirect_url' => $this->faker->sentence(),
        ];
    }
}
