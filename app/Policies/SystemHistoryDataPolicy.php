<?php

namespace App\Policies;

use App\User;
use App\SystemHistoryData;
use Illuminate\Auth\Access\HandlesAuthorization;

class SystemHistoryDataPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the systemHistoryData.
     *
     * @param  \App\User  $user
     * @param  \App\SystemHistoryData  $systemHistoryData
     * @return mixed
     */
    public function view(User $user, SystemHistoryData $systemHistoryData)
    {
        //
    }

    /**
     * Determine whether the user can create systemHistoryDatas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the systemHistoryData.
     *
     * @param  \App\User  $user
     * @param  \App\SystemHistoryData  $systemHistoryData
     * @return mixed
     */
    public function update(User $user, SystemHistoryData $systemHistoryData)
    {
        //
    }

    /**
     * Determine whether the user can delete the systemHistoryData.
     *
     * @param  \App\User  $user
     * @param  \App\SystemHistoryData  $systemHistoryData
     * @return mixed
     */
    public function delete(User $user, SystemHistoryData $systemHistoryData)
    {
        //
    }
}
