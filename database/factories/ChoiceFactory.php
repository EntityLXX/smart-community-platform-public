<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Choice;
use App\Models\Voting;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Choice>
 */
class ChoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Choice::class;

    public function definition(): array
    {
        return [
            'voting_id' => Voting::factory(),
            'name' => $this->faker->words(2, true),        ];
    }
}
