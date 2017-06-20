<?php

namespace App\Policies;

use App\User;
use App\ApplicationDocumentType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationDocumentTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the applicationDocumentType.
     *
     * @param  \App\User  $user
     * @param  \App\ApplicationDocumentType  $applicationDocumentType
     * @return mixed
     */
    public function view(User $user, ApplicationDocumentType $applicationDocumentType)
    {
        //
    }

    /**
     * Determine whether the user can create applicationDocumentTypes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->admin != NULL) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the applicationDocumentType.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        if ($user->admin != NULL) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the applicationDocumentType.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->admin != NULL) {
            return true;
        }

        return false;
    }
}
