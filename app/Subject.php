<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function path()
    {
        return ('/subjects/' . $this->slug);
    }

    public function subject_groups()
    {
        return $this->hasMany(SubjectGroup::class);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
