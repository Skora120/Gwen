<?php

namespace App\Http\Controllers;

use App\Subject;
use App\SubjectGroup;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Subject $subject
     * @param SubjectGroup $group
     * @return \Illuminate\Http\Response
     */
    public function index(Subject $subject, SubjectGroup $group)
    {
        return response($group->tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Subject $subject
     * @param SubjectGroup $group
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Subject $subject, SubjectGroup $group)
    {
        $this->authorize('create', [Task::class, $group]);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'startDate' => 'date',
            'deadline' => 'required|date|after:startDate',
        ]);


        $task = Task::create([
            'group_id' => $group->id,
            'name' => $request->name,
            'description' => $request->description,
            'startDate' => $request->startDate,
            'deadline' => $request->deadline,
        ]);

        if($request->isJson()){
            return response($task, 201);
        }

        return redirect($task->path());
    }

    /**
     * Display the specified resource.
     *
     * @param Subject $subject
     * @param SubjectGroup $group
     * @param Task $task
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Subject $subject, SubjectGroup $group, Task $task)
    {
        $this->authorize('view', [Task::class, $task]);

        $task = $task->getOriginal();

        if (request()->isJson()){
            return response($task);
        }

        return response($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
