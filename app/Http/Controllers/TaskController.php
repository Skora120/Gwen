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
    public function index()
    {
        $user = auth()->user();

        if($user->isLecturer()){
            $tasks = [];

            $user->ownedSubjects()->with(['subject_groups.tasks' => function($q) use (&$tasks){
                $tasks = $q->orderBy('created_at', 'desc')->paginate(10);
            }])->get();


            return view('task.index', compact('tasks'));
        }

        else if($user->isStudent()){
            $tasks = [];

            $user->subjectGroupUser()->with(['group.tasks' => function($q) use (&$tasks){
                $tasks = $q->orderBy('created_at', 'desc')->paginate(10);
            }])->get();

            return view('task.index', compact('tasks'));
        }

        return redirect('/');
    }

    /**
     * Display a listing of the resource for group.
     *
     * @param Subject $subject
     * @param SubjectGroup $group
     * @return \Illuminate\Http\Response
     */
    public function index_group(Subject $subject, SubjectGroup $group)
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
            'startDate' => 'date|after_or_equal:now -1 hour',
            'deadline' => 'required|date|after:startDate',
            'max_mark' => 'required|numeric|gt:0',
        ]);

        $task = Task::create([
            'group_id' => $group->id,
            'name' => $request->name,
            'description' => $request->description,
            'startDate' => $request->startDate,
            'deadline' => $request->deadline,
            'max_mark' => $request->max_mark,
            'slug' => Task::generateUniqueSlug(Str::slug($request->name)),
        ]);

        if($request->isJson()){
            return response($task, 201);
        }

        return redirect($task->path())->with('flash', 'Zadanie utworzone pomyślnie!');
    }


    /**
     * Store a newly created resource in storage.
     * Creates task for each subject group.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store_multiple(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'startDate' => 'date|after_or_equal:now -1 hour',
            'deadline' => 'required|date|after:startDate',
            'max_mark' => 'required|numeric|gt:0',
            'groups' => 'required'
        ]);

        $this->authorize('create_multiple', [Task::class, $subject, $request->groups]);

        foreach($request->groups as $group) {
            Task::create([
                'group_id' => $group,
                'name' => $request->name,
                'description' => $request->description,
                'startDate' => $request->startDate,
                'deadline' => $request->deadline,
                'max_mark' => $request->max_mark,
                'slug' => Task::generateUniqueSlug(Str::slug($request->name)),
            ]);
        }
        return redirect($subject->path())->with('flash', 'Zadania zostały utworzone pomyślnie!');
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

        if(auth()->user()->isStudent()){
            $submission = $task->submissions()->where('user_id', auth()->id())->paginate(3);
        }else {
            $submission = $task->submissions()->with('user')->paginate(15);
        }
        return view('task.show', ['task' => $task, 'submissions' => $submission]);
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
            'startDate' => 'date|after_or_equal:now -1 hour',
            'deadline' => 'required|date|after:startDate',
            'max_mark' => 'required|numeric',
        ]);

        if ($task->name != $request->name){
            $task->update([
                'name' => $request->name,
                'description' => $request->description,
                'startDate' => $request->startDate,
                'deadline' => $request->deadline,
                'max_mark' => $request->max_mark,
                'slug' => Task::generateUniqueSlug(Str::slug($request->name)),
            ]);
        }else{
            $task->update([
                'description' => $request->description,
                'startDate' => $request->startDate,
                'deadline' => $request->deadline,
                'max_mark' => $request->max_mark,
            ]);
        }

        if($request->isJson()){
            return response($task->refresh(), 201);
        }

        return redirect($task->refresh()->path())->with('flash', 'Zadanie zostało zaktualizowane pomyślnie!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subject $subject
     * @param SubjectGroup $group
     * @param Task $task
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Subject $subject, SubjectGroup $group, Task $task)
    {
        $this->authorize('delete', [$task, $group]);

        $task->delete();

        if(\request()->isJson()){
            return response(200);
        }
        return redirect($task->path())->with('flash', 'Zadanie zostało usunięte pomyślnie!');
    }
}
