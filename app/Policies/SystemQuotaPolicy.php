<?php

namespace App\Policies;

use App\User;
use App\SystemQuota;
use Illuminate\Auth\Access\HandlesAuthorization;

class SystemQuotaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the systemQuota data.
     *
     * @param  \App\User  $user
     * @param  \App\SystemQuota  $systemQuota
     * @return mixed
     */
    public function view(User $user, $school_id)
    {
        if ($user->school_editor != NULL && (bool)$user->school_editor->has_admin) {
            if ($user->school_editor->school_code == $school_id || $school_id == 'me') {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create systemQuota data.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, $school_id)
    {
        if ($user->school_editor != NULL && (bool)$user->school_editor->has_admin) {
            if ($user->school_editor->school_code == $school_id || $school_id == 'me') {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the systemQuota.
     *
     * @param  \App\User  $user
     * @param  \App\SystemQuota  $systemQuota
     * @return mixed
     */
    public function update(User $user, SystemQuota $systemQuota, $school_id)
    {
        if ($user->school_editor != NULL && (bool)$user->school_editor->has_admin) {
            if ($user->school_editor->school_code == $school_id || $school_id == 'me') {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the systemQuota.
     *
     * @param  \App\User  $user
     * @param  \App\SystemQuota  $systemQuota
     * @return mixed
     */
    public function delete(User $user, SystemQuota $systemQuota)
    {
        //
    }
}
