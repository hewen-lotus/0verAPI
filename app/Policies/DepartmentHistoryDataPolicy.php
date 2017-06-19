<?php

namespace App\Policies;

use App\User;
use App\DepartmentHistoryData;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentHistoryDataPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the departmentHistoryData.
     *
     * @param  \App\User  $user
     * @param  \App\DepartmentHistoryData  $departmentHistoryData
     * @return mixed
     */
    public function view(User $user, $school_id, $system_id, $department_id, $histories_id)
    {
        if ($user->school_editor != NULL) {
            if (($user->school_editor->school_code == $school_id || $school_id == 'me') && $histories_id == 'latest') {
                // TODO 驗證使用者是否有權限讀取此系所
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create departmentHistoryDatas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the departmentHistoryData.
     *
     * @param  \App\User  $user
     * @param  \App\DepartmentHistoryData  $departmentHistoryData
     * @return mixed
     */
    public function update(User $user, DepartmentHistoryData $departmentHistoryData)
    {
        //
    }

    /**
     * Determine whether the user can delete the departmentHistoryData.
     *
     * @param  \App\User  $user
     * @param  \App\DepartmentHistoryData  $departmentHistoryData
     * @return mixed
     */
    public function delete(User $user, DepartmentHistoryData $departmentHistoryData)
    {
        //
    }
}
