<?php

namespace App\Policies;

use App\User;
use App\SchoolData;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolDataPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->admin != NULL) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the schoolData list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->school_editor != NULL;
    }

    /**
     * Determine whether the user can view the schoolData.
     *
     * @param  \App\User  $user
     * @param  \App\SchoolData  $schoolData
     * @return mixed
     */
    public function view(User $user, SchoolData $schoolData)
    {
        return $user->school_editor->school_code === $schoolData->id;
    }

    /**
     * Determine whether the user can create schoolDatas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the schoolData.
     *
     * @param  \App\User  $user
     * @param  \App\SchoolData  $schoolData
     * @return mixed
     */
    public function update(User $user, SchoolData $schoolData)
    {
        //
    }

    /**
     * Determine whether the user can delete the schoolData.
     *
     * @param  \App\User  $user
     * @param  \App\SchoolData  $schoolData
     * @return mixed
     */
    public function delete(User $user, SchoolData $schoolData)
    {
        //
    }
}
