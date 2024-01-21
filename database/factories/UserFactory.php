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

    // $table->string('firstname');
    // $table->string('lastname');
    // $table->string('email')->unique();
    // $table->timestamp('email_verified_at')->nullable();
    // $table->string('password');
    // $table->string('role');
    // $table->text('image');
    // $table->rememberToken();
    // $table->timestamps();

    public function definition(): array
    {
        return [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'role' => fake()->numberBetween(0,1),
            'image' => fake()->imageUrl(),
            'email_verified_at' => now(),
            'password' => Hash::make(123),
            'remember_token' => Str::random(10),
        ];
    }

}
