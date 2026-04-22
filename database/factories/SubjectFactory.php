<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'course_id' => Course::factory(),
        ];
    }
}
