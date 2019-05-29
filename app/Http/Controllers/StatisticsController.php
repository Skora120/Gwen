<?php

namespace App\Http\Controllers;

use App\Subject;
use App\SubjectGroup;
use App\Submission;
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
            $submissions = Submission::where('user_id', auth()->id())->with('task')->paginate(15);

            return view('statistics.index_student', compact('submissions'));
        }else if(auth()->user()->isLecturer()){
            $subjects = auth()->user()->ownedSubjects()->paginate(15);

            return view('statistics.index_lecturer', compact('subjects'));
        }
        return redirect('/');
    }
}
