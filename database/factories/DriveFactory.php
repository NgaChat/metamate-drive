<?php

namespace Database\Factories;

use App\Models\Drive;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Drive>
 */
class DriveFactory extends Factory
{
    protected $model = Drive::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->sentence(),
            'file_id' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'file_size' => '100',
            'mime_type' => 'text',
            'thumb' => $this->faker->sentence(),
            'down_count' => '100'
        ];
    }
}
