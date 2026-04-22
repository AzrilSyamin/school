<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;

class UserPolicy
{
    /**
     * Determine whether the user can manage the target user or role.
     */
    public function manage(User $authUser, User $targetUser = null, $targetRoleId = null): bool
    {
        if ($authUser->hasRole('admin')) {
            return true;
        }

        if ($authUser->hasRole('moderator')) {
            // Cannot manage admin users
            if ($targetUser && $targetUser->hasRole('admin')) {
                return false;
            }
            // Cannot change own role
            if ($targetUser && $targetUser->id === $authUser->id && $targetRoleId && $targetRoleId != $targetUser->role_id) {
                return false;
            }
            // Cannot assign admin role
            if ($targetRoleId) {
                $role = Role::find($targetRoleId);
                if ($role && strtolower($role->name) === 'admin') {
                    return false;
                }
            }
            return true;
        }

        return false;
    }
}
