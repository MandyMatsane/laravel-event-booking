<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'location' => $this->faker->city(),
            'date_time' => $this->faker->dateTimeBetween('now', '+1 month'),
            'category_id' => Category::factory(),
            'organizer_id' => User::where('role', 'organizer')->first()->id ?? User::factory()->create()->id,
            'max_attendees' => $this->faker->numberBetween(50, 500),
            'ticket_price' => $this->faker->randomFloat(2, 10, 100),
            'status' => $this->faker->randomElement(['Upcoming', 'Ongoing', 'Completed']),
            'visibility' => $this->faker->randomElement(['Public', 'Private']),
        ];
    }
}
