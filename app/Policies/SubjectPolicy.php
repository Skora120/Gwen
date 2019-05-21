<?php

namespace App\Policies;

use App\User;
use App\Subject;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the subject.
     *
     * @param  \App\User  $user
     * @param  \App\Subject  $subject
     * @return mixed
     */
    public function view(User $user, Subject $subject)
    {

    }

    /**
     * Determine whether the user can create subjects.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isLecturer();
    }

    /**
     * Determine whether the user can update the subject.
     *
     * @param  \App\User  $user
     * @param  \App\Subject  $subject
     * @return mixed
     */
    public function update(User $user, Subject $subject)
    {
        return  $subject->user_id == $user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the subject.
     *
     * @param  \App\User  $user
     * @param  \App\Subject  $subject
     * @return mixed
     */
    public function delete(User $user, Subject $subject)
    {
        return ($user->id == $subject->user_id && !$subject->hasUsers()) || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the subject.
     *
     * @param  \App\User  $user
     * @param  \App\Subject  $subject
     * @return mixed
     */
    public function restore(User $user, Subject $subject)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the subject.
     *
     * @param  \App\User  $user
     * @param  \App\Subject  $subject
     * @return mixed
     */
    public function forceDelete(User $user, Subject $subject)
    {
        //
    }
}
