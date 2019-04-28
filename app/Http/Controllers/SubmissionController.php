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
     */
    public function store(Request $request, Subject $subject, SubjectGroup $group, Task $task)
    {
        // gate

        $request->validate([
            's_comment' => 'nullable|max:255',
            'file' => 'required|size:5000|mimes:pdf,zip,cpp',
        ]);

        $file = Storage::put('submissions/' . $task->id, $request->file);

        $submission = Submission::create([
           'user_id' => auth()->id(),
           'task_id' => $task->id,
            's_comment' => $request->s_comment,
            'file' => $file,
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
     */
    public function show(Subject $subject, SubjectGroup $group, Task $task, Submission $submission)
    {
        return response($submission);
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
