<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;

class SubjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Everyone can see subjects
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Subject $subject): bool
    {
        return true;
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
            return $user->managedCourses()->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Subject $subject): bool
    {
        if ($user->isAdminLike()) {
            return true;
        }

        if ($user->isLecturer()) {
            return $subject->course && $user->managesCourse($subject->course);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Subject $subject): bool
    {
        if ($user->isAdminLike()) {
            return true;
        }

        if ($user->isLecturer()) {
            return $subject->course && $user->managesCourse($subject->course);
        }

        return false;
    }
}
