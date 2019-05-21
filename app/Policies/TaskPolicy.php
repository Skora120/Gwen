<?php

namespace App\Policies;

use App\Subject;
use App\SubjectGroup;
use App\User;
use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function view(User $user, Task $task)
    {
        $group = $task->group;
        return $user->id == $group->owner()->id || $group->isUserInGroup($user);
    }

    /**
     * Determine whether the user can create tasks.
     *
     * @param  \App\User $user
     * @param SubjectGroup $group
     * @return mixed
     */
    public function create(User $user, SubjectGroup $group)
    {
        return $user->id == $group->owner()->id;
    }

    /**
     * Determine whether the user can create tasks.
     *
     * @param  \App\User $user
     * @param Subject $subject
     * @param $groups
     * @return mixed
     */
    public function create_multiple(User $user, Subject $subject, $groups)
    {
        $owned_groups_number_from_groups = SubjectGroup::find($groups)->where('subject_id', $subject->id)->count();

        return $user->id == $subject->user_id && $owned_groups_number_from_groups == count($groups);
    }


    /**
     * Determine whether the user can update the task.
     *
     * @param  \App\User $user
     * @param SubjectGroup $group
     * @return mixed
     */
    public function update(User $user, SubjectGroup $group)
    {
        return $user->id == $group->owner()->id;
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param  \App\User $user
     * @param SubjectGroup $group
     * @param  \App\Task $task
     * @return mixed
     */
    public function delete(User $user, Task $task, SubjectGroup $group)
    {
        return ($user->id == $group->owner()->id && !$task->submissions()->exists()) || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function restore(User $user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function forceDelete(User $user, Task $task)
    {
        //
    }
}
