<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\User;

class ClassroomPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'moderator', 'lecturer']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Classroom $classroom): bool
    {
        if ($user->isAdminLike()) {
            return true;
        }

        if ($user->isLecturer()) {
            // Check if lecturer manages the course of this classroom
            if ($classroom->course && $user->managesCourse($classroom->course)) {
                return true;
            }
            // Check if lecturer teaches any subject in this classroom
            return $user->teachesClassroom($classroom->id);
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdminLike()
               || ($user->isLecturer() && $user->managedCourses()->exists());
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Classroom $classroom): bool
    {
        return $user->isAdminLike()
               || ($user->isLecturer() && $classroom->course && $user->managesCourse($classroom->course));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Classroom $classroom): bool
    {
        return $user->isAdminLike()
               || ($user->isLecturer() && $classroom->course && $user->managesCourse($classroom->course));
    }
}
