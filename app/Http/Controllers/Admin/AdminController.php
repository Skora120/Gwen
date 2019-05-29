<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subject;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $subjects = Subject::latest()->take(4);
        $users = User::latest()->take(4);

        return view('admin.index', compact(['subjects', 'users']));
    }

}
