<?php

namespace App\Policies;

use App\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function before(Admin $user)
    {
        if ((bool)$user->admin == true) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the admin.
     *
     * @param  \App\Admin  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function view(Admin $user, Admin $admin)
    {
        return (bool)$user->admin == true;
    }

    /**
     * Determine whether the user can create admins.
     *
     * @param  \App\Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        return (bool)$user->admin == true;
    }

    /**
     * Determine whether the user can update the admin.
     *
     * @param  \App\Admin  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function update(Admin $user, Admin $admin)
    {
        return $user->username === $admin->username;
    }

    /**
     * Determine whether the user can delete the admin.
     *
     * @param  \App\Admin  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function delete(Admin $user, Admin $admin)
    {
        return (bool)$user->admin == true;
    }
}
