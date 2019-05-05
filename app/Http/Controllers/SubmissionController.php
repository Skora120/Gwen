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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
