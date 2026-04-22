<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Course;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->roleName();

        $stats = [
            'total_users' => User::count(),
            'lecturers'   => User::whereRoleName('lecturer')->count(),
            'students'    => Student::count(),
            'subjects'    => Subject::count(),
            'classrooms'  => Classroom::count(),
            'courses'     => Course::count(),
        ];

        $recentStudentsQuery = Student::with(['classroom.course']);

        if ($role === 'lecturer') {
            // Filter students by lecturer's classrooms
            $teachingClassroomIds = $user->teachingClassroomIds();
            $managedCourseClassroomIds = Classroom::whereIn('course_id', $user->managedCourseIds())->pluck('id');
            $classroomIds = $teachingClassroomIds->merge($managedCourseClassroomIds)->unique();
            
            $recentStudentsQuery->whereIn('classroom_id', $classroomIds);
        } elseif ($role === 'classrep') {
            $recentStudentsQuery->where('classroom_id', $user->classroom_id);
        }

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentStudents' => $recentStudentsQuery->latest()->take(10)->get(),
        ]);
    }
}
