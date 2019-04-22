<?php

namespace App\Http\Controllers;

use App\Subject;
use App\SubjectGroup;
use Illuminate\Http\Request;

class SubjectGroupController extends Controller
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Subject $subject, SubjectGroup $group)
    {
        $this->authorize('view', $group);

        if(request()->isJson()){
            return response($group);
        }

        return view('subjects_groups.index', ['group' => $group]);
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
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Subject $subject)
    {
        $this->authorize('update', $subject);

        $request->validate([
           'name' => 'max:255',
        ]);

        $group = SubjectGroup::create([
            'subject_id' => $subject->id,
            'name' => $request->name,
            'code' => SubjectGroup::generateUniqueCode(),
        ]);

        if($request->isJson()){
            return response($group, 201);
        }

        return redirect($group->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param SubjectGroup $group
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Subject $subject, SubjectGroup $group)
    {
        $this->authorize('update', $group);

        $request->validate([
            'name' => 'max:255',
        ]);

        $group->update([
            'name' => $request->name,
        ]);

        if($request->isJson()){
            return response($group, 201);
        }

        return redirect($group->path());
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
