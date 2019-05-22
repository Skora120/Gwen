<?php

namespace App\Providers;

use App\Subject;
use App\Task;
use function foo\func;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if(auth()) {
            View::composer('*', function($view){

                $user = auth()->user();

                if(!$user){
                    return;
                }

                if($user->isLecturer()){
                    $tasks = [];
                    $subjects = $user->ownedSubjects();

                    $subjects = $subjects->with(['subject_groups.tasks' => function($q) use (&$tasks){
                        $tasks = $q->limit(5)->orderBy('created_at', 'desc')->get();
                        return false;
                    }])->limit(5)->get();


                    $view->with(['w_tasks' => $tasks, 'w_subjects' => $subjects]);
                }else if($user->isStudent()){
                    $tasks = [];

                    $subjects = $user->subjectGroupUser()->with(['group.tasks' => function($q) use (&$tasks){
                        $tasks = $q->limit(5)->orderBy('created_at', 'desc')->get();
                    }])->with('group.subject')->limit(5)->get();

                    $view->with(['w_tasks' => $tasks, 'w_subjects' => $subjects]);
                }
            });
        }
    }
}
