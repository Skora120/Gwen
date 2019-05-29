<?php

namespace App\Providers;

use App\Subject;
use App\Task;
use function foo\func;
use Illuminate\Support\Facades\Cache;
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
                    $subjects =  $user->ownedSubjects();

                    $tasks = Cache::remember('tasks-' . $user->id, 360, function () use ($user, &$subjects){
                        $subjects->with(['subject_groups.tasks' => function($q) use (&$tasks){
                            $tasks = $q->limit(5)->orderBy('created_at', 'desc')->get();
                        }])->limit(5)->get();
                        return $tasks;
                    });
                    $subjects = $subjects->limit(5)->get();


                    $view->with(['w_tasks' => $tasks, 'w_subjects' => $subjects]);
                }else if($user->isStudent()){
                    $subjects = $user->subjectGroupUser();

                    $tasks = Cache::remember('tasks-' . $user->id, 360, function () use ($user, &$subjects){
                        $subjects->with(['group.tasks' => function($q) use (&$tasks){
                            $tasks = $q->limit(5)->orderBy('created_at', 'desc')->get();
                        }])->with('group.subject')->limit(5)->get();
                        return $tasks;
                    });

                    $subjects = $subjects->limit(5)->get();
                    $view->with(['w_tasks' => $tasks, 'w_subjects' => $subjects]);
                }
            });
        }
    }
}
