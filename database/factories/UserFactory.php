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
            'username' => 'AdminCodeTest',
            'email_verified_at' => now(),
            'phone_number' => fake()->numberBetween(7000000000, 9999999999),
            'gender' => 'male',
            'address' => 'Vyasarpadi, chennai - 39',
            'photo' => 'uploads/admin/adminprofile.webp',
            'role' => 'admin',
            // 'recover_password'=>
            'password' => static::$password ??= Hash::make('Admin12&4$'),
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
