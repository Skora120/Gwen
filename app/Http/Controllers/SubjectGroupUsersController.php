<?php

namespace App\Http\Controllers;

use App\SubjectGroup;
use App\SubjectGroupUser;
use Illuminate\Http\Request;

class SubjectGroupUsersController extends Controller
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
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $group = SubjectGroup::where('code', $request->code)->firstOrFail();

        if(SubjectGroupUser::where('group_id', $group->id)->where('user_id', auth()->id())->exists()){
            return redirect()->back()->with('flash', 'Należysz już do tej grupy!');
        }

        $this->authorize('join', $group);


        SubjectGroupUser::create([
           'user_id' => auth()->id(),
           'group_id' => $group->id
        ]);

        if($request->isJson()){
            return response($group, 201);
        }

        return redirect($group->path())->with('flash', 'Profil został zaktualizowany pomyślnie!');
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
