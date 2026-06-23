<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Project',
            'description' => fake()->paragraph(),
            'start_date' => fake()->dateTimeBetween('-2 months', 'now')?->format('Y-m-d'),
            'deadline' => fake()->dateTimeBetween('now', '+3 months')?->format('Y-m-d'),
            'owner_id' => \App\Models\User::factory(),
        ];
    }
}
