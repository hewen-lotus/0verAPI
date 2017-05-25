<?php

namespace App\Policies;

use App\User;
use App\TwoYearTechHistoryDepartmentData;
use Illuminate\Auth\Access\HandlesAuthorization;

class TwoYearTechHistoryDepartmentDataPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the twoYearTechHistoryDepartmentData.
     *
     * @param  \App\User  $user
     * @param  \App\TwoYearTechHistoryDepartmentData  $twoYearTechHistoryDepartmentData
     * @return mixed
     */
    public function view(User $user, TwoYearTechHistoryDepartmentData $twoYearTechHistoryDepartmentData)
    {
        //
    }

    /**
     * Determine whether the user can create twoYearTechHistoryDepartmentDatas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
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
