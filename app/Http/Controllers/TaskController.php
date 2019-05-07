<?php

namespace App\Http\Controllers;

use App\Subject;
use App\SubjectGroup;
use App\Submission;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'slug' => Task::generateUniqueSlug(Str::slug($request->name)),
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
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Subject $subject, SubjectGroup $group, Task $task)
    {
        $this->authorize('view', [Task::class, $task]);

        if (request()->isJson()){
            return $task->getOriginal();
        }


        return view('task.show', ['task' => $task, 'submissions' => $task->userSubmissions(auth()->user())->get()]);
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
     * @param  \Illuminate\Http\Request $request
     * @param Subject $subject
     * @param SubjectGroup $group
     * @param Task $task
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Subject $subject, SubjectGroup $group, Task $task)
    {
        $this->authorize('update', [Task::class, $group]);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'startDate' => 'date|after:now',
            'deadline' => 'required|date|after:startDate',
        ]);

        if ($task->name != $request->name){
            $task->update([
                'name' => $request->name,
                'description' => $request->description,
                'startDate' => $request->startDate,
                'deadline' => $request->deadline,
                'slug' => Task::generateUniqueSlug(Str::slug($request->name)),
            ]);
        }else{
            $task->update([
                'description' => $request->description,
                'startDate' => $request->startDate,
                'deadline' => $request->deadline,
            ]);
        }

        if($request->isJson()){
            return response($task->refresh(), 201);
        }

        return redirect($task->refresh()->path());
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
