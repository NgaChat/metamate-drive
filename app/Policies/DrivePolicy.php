<?php

namespace App\Policies;

use App\Models\Drive;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;


class DrivePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Drive $drive)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Drive $drive)
    {

        $drive_id = $drive::where('user_id', $user->id)->first();

        var_dump($user->id);
        var_dump($drive_id->user_id);
        return $user->id === $drive_id->user_id
            ? Response::allow()
            : Response::deny('You do not own this drive.');
    }

    public function isUser()
    {
        $user = request()->user();
        $drive = request()->drive();
        return $user->id === $drive->user_id
            ? Response::allow()
            : Response::deny('You do not own this drive.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Drive $drive)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Drive $drive)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Drive  $drive
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Drive $drive)
    {
        //
    }
}
