<?php

namespace App\Policies;

use App\User;
use App\GraduateDepartmentHistoryData;
use App\DepartmentEditorPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class GraduateDepartmentHistoryDataPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the graduateDepartmentHistoryData.
     *
     * @param  \App\User  $user
     * @param  \App\GraduateDepartmentHistoryData  $graduateDepartmentHistoryData
     * @return mixed
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
     * Determine whether the user can create graduateDepartmentHistoryDatas.
     *
     * @param  \App\User  $user
     * @return mixed
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
