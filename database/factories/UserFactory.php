<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(), // Using firstName for better example data
            'surname' => fake()->lastName(), // <-- ADDED
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(), // Optional, can be null if verification not implemented
            'phone' => fake()->phoneNumber(), // <-- ADDED
            'country' => fake()->countryCode(), // <-- ADDED (Using country code 'US', 'GB' etc.)
            'gender' => fake()->randomElement(['Male', 'Female', 'Other']), // <-- ADDED (Adjust options as needed)
            'password' => static::$password ??= Hash::make('password'), // Default password 'password'
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
