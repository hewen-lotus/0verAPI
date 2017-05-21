<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->admin != NULL && (bool)$user->admin->has_admin) {
            return true;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | admin's
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the user can view admin list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list_admin(User $user)
    {
        if ($user->admin != NULL) {
            return (bool)$user->admin->has_admin;
        }

        return false;
    }

    /**
     * Determine whether the user can view the admin.
     *
     * @param  \App\User  $user
     * @param  \App\User  $admin
     * @return mixed
     */
    public function view_admin(User $user, User $admin)
    {
        return $user->admin->username === $admin->admin->username;
    }

    /**
     * Determine whether the user can create admins.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_admin(User $user)
    {
        if ($user->admin != NULL) {
            return (bool)$user->admin->has_admin;
        }

        return false;
    }

    /**
     * Determine whether the user can update the admin.
     *
     * @param  \App\User  $user
     * @param  \App\User  $admin
     * @return mixed
     */
    public function update_admin(User $user, User $admin)
    {
        return $user->admin->username === $admin->admin->username;
    }

    /**
     * Determine whether the user can delete the admin.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete_admin(User $user)
    {
        if ($user->admin != NULL) {
            return (bool)$user->admin->has_admin;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | SchoolEditor
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the user can view editor list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list_schooleditor(User $user, $school_code)
    {
        if ($user->admin != NULL) {
            return true;
        }

        if ((bool)$user->school_editor->has_admin && $user->school_editor->school_code == $school_code) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the editor.
     *
     * @param  \App\User  $user
     * @param  \App\User  $editor
     * @return mixed
     */
    public function view_schooleditor(User $user, User $editor)
    {
        if ($user->admin != NULL) {
            return true;
        }

        if ((bool)$user->school_editor->has_admin) {
            return true;
        }

        return $user->school_editor->username === $editor->school_editor->username;
    }

    /**
     * Determine whether the user can create editors.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_schooleditor(User $user, $school_code)
    {
        if ($user->admin != NULL) {
            return true;
        }

        if ((bool)$user->school_editor->has_admin && $user->school_editor->school_code == $school_code) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the editor.
     *
     * @param  \App\User  $user
     * @param  \App\User  $editor
     * @return mixed
     */
    public function update_schooleditor(User $user, User $editor)
    {
        if ($user->admin != NULL) {
            return true;
        }

        return $user->school_editor->username === $editor->school_editor->username;
    }

    /**
     * Determine whether the user can delete the editor.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete_schooleditor(User $user)
    {
        if ($user->admin != NULL) {
            return true;
        }

        return (bool)$user->school_editor->has_admin;
    }

    /*
    |--------------------------------------------------------------------------
    | SchoolReviewer
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether the user can view reviewer list.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list_schoolreviewer(User $user)
    {
        if ($user->admin != NULL) {
            return true;
        }

        return (bool)$user->school_reviewer->has_admin;
    }

    /**
     * Determine whether the user can view a reviewer.
     *
     * @param  \App\User  $user
     * @param  \App\User  $reviewer
     * @return mixed
     */
    public function view_schoolreviewer(User $user, User $reviewer)
    {
        if ($user->admin != NULL) {
            return true;
        }

        return $user->school_reviewer->username === $reviewer->school_reviewer->username;
    }

    /**
     * Determine whether the user can create reviewers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_schoolreviewer(User $user)
    {
        if ($user->admin != NULL) {
            return true;
        }

        return (bool)$user->school_reviewer->has_admin;
    }

    /**
     * Determine whether the user can update a reviewer.
     *
     * @param  \App\User  $user
     * @param  \App\User  $reviewer
     * @return mixed
     */
    public function update_schoolreviewer(User $user, User $reviewer)
    {
        if ($user->admin != NULL) {
            return true;
        }

        return $user->school_reviewer->username === $reviewer->school_reviewer->username;
    }

    /**
     * Determine whether the user can delete a reviewer.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete_schoolreviewer(User $user)
    {
        if ($user->admin != NULL) {
            return true;
        }

        return (bool)$user->school_reviewer->has_admin;
    }
}
