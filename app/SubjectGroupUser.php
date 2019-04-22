<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectGroupUser extends Model
{
    protected $guarded = [];

    public function user()
    {
        $this->hasOne('App\User');
    }
}
