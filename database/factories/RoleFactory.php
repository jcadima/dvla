<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Admin', 'User', 'Editor', 'Moderator']),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Admin',
        ]);
    }

    public function user(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'User',
        ]);
    }
}
