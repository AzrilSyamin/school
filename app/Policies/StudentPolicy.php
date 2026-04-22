<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'moderator', 'lecturer', 'classrep']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Student $student): bool
    {
        if ($user->isAdminLike()) {
            return true;
        }

        if ($user->isLecturer()) {
            // Check if lecturer manages the course
            if ($student->classroom && $student->classroom->course && $user->managesCourse($student->classroom->course)) {
                return true;
            }
            // Check if lecturer teaches this classroom
            return $student->classroom_id && $user->teachesClassroom($student->classroom_id);
        }

        if ($user->isClassrep()) {
            return $user->classroom_id === $student->classroom_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->isAdminLike()) {
            return true;
        }

        if ($user->isLecturer()) {
            // Only Course Managers can create students in their course's classrooms
            // This would usually be checked in the controller context (which course?)
            // But generically, if they manage ANY course.
            return $user->managedCourses()->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Student $student): bool
    {
        if ($user->isAdminLike()) {
            return true;
        }

        if ($user->isLecturer()) {
            return $student->classroom && $student->classroom->course && $user->managesCourse($student->classroom->course);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Student $student): bool
    {
        if ($user->isAdminLike()) {
            return true;
        }

        if ($user->isLecturer()) {
            return $student->classroom && $student->classroom->course && $user->managesCourse($student->classroom->course);
        }

        return false;
    }
}
