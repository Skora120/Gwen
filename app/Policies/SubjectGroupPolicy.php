<?php

namespace App\Policies;

use App\User;
use App\SubjectGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the subject group.
     *
     * @param  \App\User  $user
     * @param  \App\SubjectGroup  $subjectGroup
     * @return mixed
     */
    public function view(User $user, SubjectGroup $subjectGroup)
    {
        if ($subjectGroup->subject->user_id == $user->id || $user->isAdmin())
            return true;

        return $subjectGroup->isUserInGroup($user);
    }

    /**
     * Determine whether the user can create subject groups.
     *
     * @param  \App\User $user
     * @param Subject $subject
     * @return mixed
     */
    public function create(User $user)
    {
    }

    /**
     * Determine whether the user can join subject groups.
     *
     * @param  \App\User $user
     * @param SubjectGroup $subjectGroup
     * @return mixed
     */
    public function join(User $user, SubjectGroup $subjectGroup)
    {
        if ($user->id == $subjectGroup->subject()->value('user_id'))
            return false;


        return !$subjectGroup->isUserInGroup($user);
    }

    /**
     * Determine whether the user can update the subject group.
     *
     * @param  \App\User  $user
     * @param  \App\SubjectGroup  $subjectGroup
     * @return mixed
     */
    public function update(User $user, SubjectGroup $subjectGroup)
    {
        return $subjectGroup->subject->user_id == $user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the subject group.
     *
     * @param  \App\User  $user
     * @param  \App\SubjectGroup  $subjectGroup
     * @return mixed
     */
    public function delete(User $user, SubjectGroup $subjectGroup)
    {
        return ($user->id == $subjectGroup->owner()->id && !$subjectGroup->users()->exists()) || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the subject group.
     *
     * @param  \App\User  $user
     * @param  \App\SubjectGroup  $subjectGroup
     * @return mixed
     */
    public function restore(User $user, SubjectGroup $subjectGroup)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the subject group.
     *
     * @param  \App\User  $user
     * @param  \App\SubjectGroup  $subjectGroup
     * @return mixed
     */
    public function forceDelete(User $user, SubjectGroup $subjectGroup)
    {
        //
    }
}
