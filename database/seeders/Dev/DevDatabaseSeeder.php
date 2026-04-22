<?php

namespace Database\Seeders\Dev;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use App\Models\Stage;
use App\Models\Classroom;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;

class DevDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Add Courses
        $courses = collect([
            ['name' => 'Information Technology', 'code' => 'BIT'],
            ['name' => 'Business Management', 'code' => 'BBM'],
            ['name' => 'Graphic Design', 'code' => 'BGD']
        ])->map(function ($data) {
            return \App\Models\Course::create($data);
        });

        // Add Dummy Admin User
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'System',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
            'is_active' => 1,
            'picture' => 'images/default.jpg'
        ]);

        // Add Dummy Moderator User
        User::create([
            'first_name' => 'Moderator',
            'last_name' => 'User',
            'username' => 'moderator',
            'email' => 'moderator@example.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
            'is_active' => 1,
            'picture' => 'images/default.jpg'
        ]);

        // Add Dummy Lecturers
        $lecturers = User::factory(10)->create(['role_id' => 3]);

        // Assign Course Managers
        $courses->each(function ($course) use ($lecturers) {
            $course->update(['manager_id' => $lecturers->random()->id]);
        });

        // Add Classes
        $classrooms = collect(['Group A', 'Group B', 'Group C', 'Group D'])->map(function ($name) use ($courses) {
            return Classroom::create([
                'name' => $name,
                'course_id' => $courses->random()->id,
            ]);
        });

        // Add Subjects linked to Courses
        $subjects = collect([
            'BIT' => ['Basic Linux', 'Network Security', 'Web Development'],
            'BBM' => ['Accounting', 'Marketing', 'Business Law'],
            'BGD' => ['UI/UX Design', 'Typography', 'Digital Illustration']
        ]);

        foreach ($courses as $course) {
            $courseSubjects = $subjects->get($course->code, ['General Subject']);
            foreach ($courseSubjects as $subjectName) {
                Subject::create([
                    'name' => $subjectName,
                    'course_id' => $course->id,
                ]);
            }
        }

        // Assign Lecturers and Subjects to Classrooms
        $classrooms->each(function ($classroom) use ($lecturers) {
            // Only get subjects from the classroom's course
            $courseSubjects = Subject::where('course_id', $classroom->course_id)->get();
            foreach ($courseSubjects as $subject) {
                $classroom->subjects()->attach($subject->id, [
                    'lecturer_id' => $lecturers->random()->id
                ]);
            }
        });

        // Add Classreps for each classroom
        $classrooms->each(function ($classroom, $index) {
            User::create([
                'first_name' => 'Classrep',
                'last_name' => $classroom->name,
                'username' => 'classrep' . ($index + 1),
                'email' => 'classrep' . ($index + 1) . '@example.com',
                'password' => bcrypt('password'),
                'role_id' => 5, // Classrep
                'classroom_id' => $classroom->id,
                'is_active' => 1,
                'picture' => 'images/default.jpg'
            ]);
        });

        // Add Students
        $classrooms->each(function ($classroom) {
            $students = Student::factory(15)->create([
                'classroom_id' => $classroom->id,
            ]);

            // Find classrep for this classroom
            $classrep = User::where('role_id', 5)->where('classroom_id', $classroom->id)->first();
            // Find a subject for this classroom
            $subject = $classroom->subjects()->first();

            if ($classrep && $subject) {
                foreach ($students as $student) {
                    \App\Models\Attendance::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'classroom_id' => $classroom->id,
                        'date' => now()->toDateString(),
                        'status' => 'Hadir',
                        'recorded_by' => $classrep->id,
                    ]);
                }
            }
        });
    }
}
