<?php

namespace App\Policies;

use App\User;
use App\GraduateDepartmentHistoryData;
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
    public function view(User $user, GraduateDepartmentHistoryData $graduateDepartmentHistoryData)
    {
        //
    }

    /**
     * Determine whether the user can create graduateDepartmentHistoryDatas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
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
