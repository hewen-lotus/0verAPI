<?php

namespace App\Policies;

use App\User;
use App\SchoolHistoryData;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolHistoryDataPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the schoolHistoryData.
     *
     * @param  \App\User  $user
     * @param  string $school_id
     * @param  string $history_id
     * @return mixed
     */
    public function view(User $user, $school_id, $history_id)
    {
        if ($user->admin != NULL && $school_id != 'me') {
            return true;
        }

        if ($user->school_editor != NULL) {
            if (($user->school_editor->school_code == $school_id || $school_id == 'me') && $history_id == 'latest') {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create schoolHistoryDatas.
     *
     * @param  \App\User  $user
     * @param  string  $school_id
     * @return mixed
     */
    public function create(User $user, $school_id)
    {
        if ($user->admin != NULL && $school_id != 'me') {
            return true;
        }

        if ($user->school_editor != NULL) {
            if (($user->school_editor->school_code == $school_id || $school_id == 'me') && (bool)$user->school_editor->has_admin) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the schoolHistoryData.
     *
     * @param  \App\User  $user
     * @param  \App\SchoolHistoryData  $schoolHistoryData
     * @return mixed
     */
    public function update(User $user, SchoolHistoryData $schoolHistoryData)
    {
        //
    }

    /**
     * Determine whether the user can delete the schoolHistoryData.
     *
     * @param  \App\User  $user
     * @param  \App\SchoolHistoryData  $schoolHistoryData
     * @return mixed
     */
    public function delete(User $user, SchoolHistoryData $schoolHistoryData)
    {
        //
    }
}
