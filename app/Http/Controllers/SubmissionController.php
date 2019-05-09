<?php

namespace App\Http\Controllers;

use App\Subject;
use App\SubjectGroup;
use App\Submission;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
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
     * @param Task $task
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Subject $subject, SubjectGroup $group, Task $task)
    {
        $this->authorize('index', [Submission::class, $subject]);

        if (request()->isJson()){
            return $task->submissions;
        }

        return redirect($task->path());
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
     * @param Task $task
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Subject $subject, SubjectGroup $group, Task $task)
    {
        $this->authorize('create', [Submission::class, $task]);

        $request->validate([
            's_comment' => 'nullable|max:255',
            'file' => 'required|between:0,5000|mimetypes:application/pdf,application/zip,text/plain,text/x-c++,text/x-c',
        ]);

        $file = Storage::putFileAs('submissions/' . $task->id, $request->file('file'), md5($request->file('file') . time()));

        $submission = Submission::create([
           'user_id' => auth()->id(),
           'task_id' => $task->id,
            's_comment' => $request->s_comment,
            'file' => $file,
            'file_extension' => $request->file('file')->getClientOriginalExtension()
        ]);

        if($request->isJson()){
            return response($submission);
        }

        return redirect($submission->path());
    }

    /**
     * Display the specified resource.
     *
     * @param Subject $subject
     * @param SubjectGroup $group
     * @param Task $task
     * @param Submission $submission
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Subject $subject, SubjectGroup $group, Task $task, Submission $submission)
    {
        $this->authorize('view', [$submission, $subject]);

        if(\request()->isJson()){
            return response($submission);
        }

        return view('submissions.show', compact('submission'));
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
     * @param Submission $submission
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Subject $subject, SubjectGroup $group, Task $task, Submission $submission)
    {
        $this->authorize('update', [$submission, $subject]);

        $request->validate([
            'r_comment' => 'max:255',
            'mark' => 'required|numeric',
        ]);

        $submission->update([
            'r_comment' => $request->r_comment,
            'mark' => $request->mark,
        ]);

        if($request->isJson()){
            return response($submission, 201);
        }
        return redirect($submission->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Subject $subject, SubjectGroup $group, Task $task, Submission $submission)
    {
        $this->authorize('delete', Submission::class);

        $submission->delete();

        if(\request()->isJson()){
            return response(200);
        }
        return redirect($task->path());
    }

    /**
     * Download file from submission
     *
     * @param Subject $subject
     * @param SubjectGroup $group
     * @param Task $task
     * @param Submission $submission
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function download(Subject $subject, SubjectGroup $group, Task $task, Submission $submission)
    {
        return response()->download(storage_path('app/' . $submission->file),   bin2hex(random_bytes(2)) . '.'. $submission->file_extension, [], 'inline');
    }
}
