<?php

namespace App\Policies;

use App\Subject;
use App\Task;
use App\User;
use App\Submission;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can see all the submission.
     *
     * @param  \App\User $user
     * @param  \App\Submission $submission
     * @param Subject $subject
     * @return mixed
     */
    public function index(User $user, Subject $subject)
    {
        return $user->id == $subject->user->id;
    }


    /**
     * Determine whether the user can view the submission.
     *
     * @param  \App\User $user
     * @param  \App\Submission $submission
     * @param Subject $subject
     * @return mixed
     */
    public function view(User $user, Submission $submission, Subject $subject)
    {
        return $user->id == $subject->user->id || $submission->user_id == $user->id;
    }

    /**
     * Determine whether the user can create submissions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Task $task)
    {
        // check if submission date is in valid time frame
        if ($task->startDate > date(now()) || $task->deadline < date(now()))
            return false;

        return $task->group->isUserInGroup($user) and $task->submissions->where('user_id', $user->id)->count() < 3;
    }

    /**
     * Determine whether the user can update the submission.
     *
     * @param  \App\User  $user
     * @param  \App\Submission  $submission
     * @return mixed
     */
    public function update(User $user, Submission $submission, Subject $subject)
    {
        return $user->id == $subject->user_id;
    }

    /**
     * Determine whether the user can delete the submission.
     *
     * @param  \App\User  $user
     * @param  \App\Submission  $submission
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the submission.
     *
     * @param  \App\User  $user
     * @param  \App\Submission  $submission
     * @return mixed
     */
    public function restore(User $user, Submission $submission)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the submission.
     *
     * @param  \App\User  $user
     * @param  \App\Submission  $submission
     * @return mixed
     */
    public function forceDelete(User $user, Submission $submission)
    {
        //
    }
}
