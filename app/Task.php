<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo('App\SubjectGroup');
    }

    public function path()
    {
        return ($this->group->path() . '/' . $this->id);
    }
}
