<?php

namespace App\Http\Controllers;

use App\Subject;
use App\SubjectGroup;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(auth()->user()->isStudent()) {
            $submissions = auth()->user()->submissions()->with('task.group.subject')->orderBy('mark', 'desc')->paginate(25)->groupBy('task_id');

            return view('statistics.index_student', compact('submissions'));
        }else if(auth()->user()->isLecturer()){
            $subjects = auth()->user()->ownedSubjects()->paginate(25);

            return view('statistics.index_lecturer', compact('subjects'));
        }
        return redirect('/');
    }
}
