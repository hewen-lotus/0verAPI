<?php

namespace App\Policies;

use App\User;
use App\TwoYearTechHistoryDepartmentData;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class TwoYearTechHistoryDepartmentDataPolicy
 * @package App\Policies
 */

class TwoYearTechHistoryDepartmentDataPolicy
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
     * Determine whether the user can update the twoYearTechHistoryDepartmentData.
     *
     * @param  \App\User  $user
     * @param  \App\TwoYearTechHistoryDepartmentData  $twoYearTechHistoryDepartmentData
     * @return mixed
     */
    public function update(User $user, TwoYearTechHistoryDepartmentData $twoYearTechHistoryDepartmentData)
    {
        //
    }

    /**
     * Determine whether the user can delete the twoYearTechHistoryDepartmentData.
     *
     * @param  \App\User  $user
     * @param  \App\TwoYearTechHistoryDepartmentData  $twoYearTechHistoryDepartmentData
     * @return mixed
     */
    public function delete(User $user, TwoYearTechHistoryDepartmentData $twoYearTechHistoryDepartmentData)
    {
        //
    }
}
