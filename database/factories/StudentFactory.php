<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'student_id' => 'S' . fake()->unique()->numberBetween(10000, 99999),
            'email' => fake()->unique()->safeEmail(),
            'age' => fake()->numberBetween(18, 30),
            'gender' => fake()->randomElement(['Lelaki', 'Perempuan']),
            'classroom_id' => null, // Should be assigned manually or via state
        ];
    }
}
