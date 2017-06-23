<?php

namespace App\Policies;

use App\User;
use App\GraduateDepartmentHistoryData;
use App\DepartmentEditorPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class GraduateDepartmentHistoryDataPolicy
 * @package App\Policies
 */

class GraduateDepartmentHistoryDataPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param $school_id
     * @param $department_id
     * @return bool
     */
    public function view(User $user, $school_id, $department_id)
    {
        if ($user->school_editor != NULL && $user->school_editor->school_code == $school_id) {
            if ($user->school_editor->has_admin) {
                return true;
            } else if (
                DepartmentEditorPermission::where('username', '=', $user->username)
                    ->where('dept_id', '=', $department_id)->exists()
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param User $user
     * @param $school_id
     * @param $department_id
     * @return bool
     */
    public function create(User $user, $school_id, $department_id)
    {
        if ($user->school_editor != NULL && $user->school_editor->school_code == $school_id) {
            if ($user->school_editor->has_admin) {
                return true;
            } else if (
            DepartmentEditorPermission::where('username', '=', $user->username)
                ->where('dept_id', '=', $department_id)->exists()
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the graduateDepartmentHistoryData.
     *
     * @param  \App\User  $user
     * @param  \App\GraduateDepartmentHistoryData  $graduateDepartmentHistoryData
     * @return mixed
     */
    public function update(User $user, GraduateDepartmentHistoryData $graduateDepartmentHistoryData)
    {
        //
    }

    /**
     * Determine whether the user can delete the graduateDepartmentHistoryData.
     *
     * @param  \App\User  $user
     * @param  \App\GraduateDepartmentHistoryData  $graduateDepartmentHistoryData
     * @return mixed
     */
    public function delete(User $user, GraduateDepartmentHistoryData $graduateDepartmentHistoryData)
    {
        //
    }
}
