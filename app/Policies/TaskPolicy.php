<?php

namespace App\Policies;

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
        return $user->id == $task->group->owner()->id || $this->isUserInGroup($user, $task->group);
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
     * Determine whether the user can update the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {
        //
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

    public function isUserInGroup(User $user, SubjectGroup $subjectGroup)
    {
        $users = $subjectGroup->users()->get();

        foreach ($users as $value){
            if ($value->user_id == $user->id)
                return true;
        }
        return false;
    }
}
