<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $guarded = [];

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    public function path()
    {
        return ($this->task->path() . '/' . $this->id);
    }
}
