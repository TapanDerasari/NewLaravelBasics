<?php

namespace App\Policies;

use App\User;
use App\Share;
use Illuminate\Auth\Access\HandlesAuthorization;

class SharePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the share.
     *
     * @param  \App\User  $user
     * @param  \App\share  $share
     * @return mixed
     */
    public function view(User $user, share $share)
    {
        //
    }

    /**
     * Determine whether the user can create shares.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->email,[
            'tapan@topsinfosolutions.com'
        ]);
    }

    /**
     * Determine whether the user can update the share.
     *
     * @param  \App\User  $user
     * @param  \App\share  $share
     * @return mixed
     */
    public function update(User $user, share $share)
    {
        //
    }

    /**
     * Determine whether the user can delete the share.
     *
     * @param  \App\User  $user
     * @param  \App\share  $share
     * @return mixed
     */
    public function delete(User $user, share $share)
    {
        return in_array($user->email,[
            'tapan@topsinfosolutions.com'
        ]);
    }

    /**
     * Determine whether the user can restore the share.
     *
     * @param  \App\User  $user
     * @param  \App\share  $share
     * @return mixed
     */
    public function restore(User $user, share $share)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the share.
     *
     * @param  \App\User  $user
     * @param  \App\share  $share
     * @return mixed
     */
    public function forceDelete(User $user, share $share)
    {
        //
    }

    public function chart(User $user)
    {
        //
    }
}
