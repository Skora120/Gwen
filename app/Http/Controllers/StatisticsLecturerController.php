<?php

namespace App\Http\Controllers;

use App\Subject;
use App\SubjectGroup;
use Illuminate\Http\Request;

class StatisticsLecturerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'lecturer']);
    }

    /**
     * @param Subject $subject
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function subject_show(Subject $subject)
    {
        $this->authorize('update', $subject);

        $groups = $subject->subject_groups()->withCount('users')->paginate(25);

        return view('statistics.show_subjects', compact('groups'));
    }

    /**
     * @param Subject $subject
     * @param SubjectGroup $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function group_show(Subject $subject, SubjectGroup $group)
    {
        $this->authorize('update', $subject);

        $tasks = $group->tasks()->withCount('allModelSubmissions')->with('submissions');
        $tasksCount = $tasks->count();
        $tasks = $tasks->paginate(5);

            return view('statistics.show_group', compact('tasks', 'tasksCount'));
    }
}
