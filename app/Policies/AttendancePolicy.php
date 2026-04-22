<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Attendance $attendance): bool
    {
        if ($user->isAdminLike()) return true;

        if ($user->isLecturer()) {
            // Check if teaches or manages course
            $isTeacher = $user->teachesSubjectInClassroom($attendance->classroom_id, $attendance->subject_id);
                
            $isCourseManager = $user->managesCourse($attendance->classroom->course);
            
            return $isTeacher || $isCourseManager;
        }

        if ($user->isClassrep()) {
            return $user->classroom && $attendance->classroom && $user->classroom->course_id === $attendance->classroom->course_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'moderator', 'lecturer', 'classrep']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attendance $attendance): bool
    {
        if ($user->isAdminLike()) return true;
        
        if ($user->hasRole(['lecturer', 'classrep'])) {
            // ONLY the person who recorded it OR the assigned teacher can edit?
            // The spec says: "Boleh edit kehadiran untuk course yang dia ajar sahaja" (for Manager/Lecturer)
            
            $isTeacher = $user->teachesSubjectInClassroom($attendance->classroom_id, $attendance->subject_id);
            
            return $isTeacher;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attendance $attendance): bool
    {
        if ($user->isAdminLike()) return true;
        
        if ($user->isLecturer()) {
            return $user->managesCourse($attendance->classroom->course);
        }
        
        return false;
    }
}
