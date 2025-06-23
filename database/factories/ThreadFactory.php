<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Thread;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Thread::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // link to comment/thread creator
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];
    }
}
