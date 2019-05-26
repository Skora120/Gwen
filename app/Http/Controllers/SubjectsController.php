<?php

namespace App\Http\Controllers;

use App\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectsController extends Controller
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
        $user = auth()->user();
        $subjects = [];
        if($user->isLecturer()) {
            $subjects = $user->ownedSubjects()->orderBy('updated_at', 'desc')->paginate(10);
        }else{
            $subjects = $user->subjects()->orderBy('updated_at', 'desc')->paginate(10);
        }
        if(request()->isJson()){
            return $subjects;
        }

        return view('subjects.index', ['subjects' => $subjects]);
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
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Subject::class);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        $subject = Subject::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name. '-'. Carbon::now()->format('H:i:s'))
        ]);

        if($request->isJson()){
            return response($subject, 201);
        }

        return redirect($subject->path());

    }

    /**
     * Display the specified resource.
     *
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        if(auth()->user()->isStudent()) {
            $userGroups = $subject->subject_groups()->with(['users' => function($q){
                $q->where('user_id', auth()->id());
            }])->paginate(10)->filter(function ($value) {
                return !empty($value->users[0]);
            });
        }else{
            $userGroups = $subject->subject_groups()->paginate(10);
        }

        if(\request()->isJson()){
            return response($subject, $userGroups);
        }

        return view('subjects.show', compact('subject', 'userGroups'));
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
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Subject $subject)
    {
        $this->authorize('update', $subject);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        $subject->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name. '-'. Carbon::now()->format('H:i:s'))
        ]);

        if($request->isJson()){
            return response($subject, 201);
        }

        return redirect($subject->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subject $subject
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Subject $subject)
    {
        $this->authorize('delete', $subject);

        $subject->delete();

        if(\request()->isJson()){
            return response(200);
        }
        return redirect('/');
    }
}
