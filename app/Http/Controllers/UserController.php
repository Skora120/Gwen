<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = auth()->user();
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $request->validate([
            'password' => 'string|min:8|confirmed',
            'email' => 'string|email|max:255|unique:users',
            'student_id' => 'integer|min:6',

        ]);

        $user = auth()->user();

        $user->update([
            'email'      => $request->email         ? $request->email                   : $user->email,
            'student_id' => $request->student_id    ? $request->student_id              : $user->student_id,
            'password'   => $request->password      ? Hash::make($request->password)    : $user->password,
        ]);

        return redirect()->back()->with('success', 'Porfil zakutalizowany pomyślnie!');
    }
}
