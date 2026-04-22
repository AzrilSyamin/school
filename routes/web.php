<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes (accessible by all authenticated roles)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Academic Management - Role-based access controlled via Policies
    Route::middleware('role:admin,moderator,lecturer')->group(function () {
        Route::resource('courses', CourseController::class)->except(['show']);
        Route::resource('classrooms', ClassroomController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('students', StudentController::class);
    });

    // Administrative Management - Admin & Moderator only
    Route::middleware('role:admin,moderator')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('lecturers', LecturerController::class);
        
        // System Settings
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    });

    // Attendance routes
    Route::middleware('role:admin,moderator,lecturer,classrep')->group(function () {
        Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
        Route::post('attendances', [AttendanceController::class, 'store'])->name('attendances.store');
        Route::get('attendances/show', [AttendanceController::class, 'show'])->name('attendances.show');
        Route::get('attendances/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');
    });
});

require __DIR__.'/auth.php';
