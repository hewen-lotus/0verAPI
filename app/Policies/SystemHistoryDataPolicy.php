<?php

namespace App\Policies;

use App\User;
use App\SystemHistoryData;
use Illuminate\Auth\Access\HandlesAuthorization;

class SystemHistoryDataPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the systemHistoryData quota.
     *
     * @param  \App\User  $user
     * @param  \App\SystemHistoryData  $systemHistoryData
     * @return mixed
     */
    public function view_quota(User $user, SystemHistoryData $systemHistoryData, $school_id)
    {
        if ($user->school_editor != NULL) {
            if (($user->school_editor->school_code == $school_id || $school_id == 'me') && $histories_id == 'latest') {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can view the systemHistoryData info.
     *
     * @param  \App\User  $user
     * @param  \App\SystemHistoryData  $systemHistoryData
     * @return mixed
     */
    public function view_info(User $user, SystemHistoryData $systemHistoryData, $school_id)
    {
        if ($user->school_editor != NULL) {
            if (($user->school_editor->school_code == $school_id || $school_id == 'me') && $histories_id == 'latest') {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create systemHistoryDatas quota.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_quota(User $user)
    {
        if ($user->school_editor != NULL) {
            if (($user->school_editor->school_code == $school_id || $school_id == 'me') && $histories_id == 'latest') {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create systemHistoryDatas info.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_info(User $user)
    {
        if ($user->school_editor != NULL) {
            if (($user->school_editor->school_code == $school_id || $school_id == 'me') && $histories_id == 'latest') {
                return true;
            }
        }

        return false;
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
