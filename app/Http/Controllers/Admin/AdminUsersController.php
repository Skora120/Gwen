<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('last_name', 'asc')->paginate(25);

        return view('admin.user.index', compact('users'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $submissions = $user->submissions()->paginate(15);
        return view('admin.user.show', ['user' => $user, 'submissions' => $submissions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'email' => 'nullable|string|email|confirmed|max:255|unique:users',
            'student_id' => 'nullable|string|min:6|unique:users',
            'type' => 'nullable|integer|between:0,2'

        ]);

        $user->update([
            'first_name' => $request->first_name    ? $request->first_name              : $user->first_name,
            'last_name' => $request->last_name      ? $request->last_name               : $user->last_name,
            'email'      => $request->email         ? $request->email                   : $user->email,
            'student_id' => $request->student_id    ? $request->student_id              : $user->student_id,
            'password'   => $request->password      ? Hash::make($request->password)    : $user->password,
            'type'   => $request->type              ? $request->type                    : $user->type,
        ]);

        return redirect()->back()->with('flash', 'Profil został zaktualizowany pomyślnie!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
