<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'workos_id' => 'fake-'.Str::random(10),
            'remember_token' => Str::random(10),
            'avatar' => '',
        ];
    }

    /**
     * Assign the user as a user.
     */
    public function user(): self
    {
        return $this->assignRole('User');
    }

    /**
     * @param  array|\Spatie\Permission\Contracts\Role|string  ...$roles
     */
    private function assignRole(...$roles): self
    {
        return $this->afterCreating(fn (User $user) => $user->syncRoles($roles));
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
