<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->jobTitle() . ' Course',
            'code' => strtoupper(fake()->unique()->lexify('???')),
            'manager_id' => null,
        ];
    }
}
