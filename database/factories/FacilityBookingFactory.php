<?php

namespace Database\Factories;

use App\Models\FacilityBooking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FacilityBooking>
 */
class FacilityBookingFactory extends Factory
{
    protected $model = FacilityBooking::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = now()->addDays(3)->setTime(10, 0);
        $endTime = (clone $startTime)->addHours(2);

        return [
            'user_id' => User::factory(),
            'facility' => 'Surau Hall',
            'purpose' => $this->faker->sentence,
            'date' => $startTime->toDateString(),
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'status' => 'pending',
            'admin_notes' => null,
        ];
    }
}
