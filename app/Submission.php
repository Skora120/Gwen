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

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function fileWithExtension()
    {
        return ($this->file . '.' . $this->file_extension);
    }

    public function path()
    {
        return ($this->task->path() . '/submissions/' . $this->id);
    }
}
