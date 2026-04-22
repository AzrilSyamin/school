<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'subject_id' => Subject::factory(),
            'classroom_id' => Classroom::factory(),
            'date' => fake()->date(),
            'status' => fake()->randomElement(['Hadir', 'Ponteng', 'Sakit', 'Kecemasan']),
            'remarks' => fake()->sentence(),
            'recorded_by' => User::factory(),
        ];
    }
}
