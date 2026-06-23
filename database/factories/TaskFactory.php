<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['pending', 'completed']);
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->optional(0.8)->paragraph(),
            'due_date' => $this->faker->optional(0.7)->dateTimeBetween('-1 week', '+3 weeks')?->format('Y-m-d'),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'status' => $status,
            'completed_at' => $status === 'completed' ? $this->faker->dateTimeBetween('-3 days', 'now') : null,
        ];
    }
}
