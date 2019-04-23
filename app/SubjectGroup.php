<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectGroup extends Model
{
    protected $guarded = [];

    public static function generateUniqueCode()
    {
        $length = 3;
        $result = bin2hex(random_bytes($length));
        $failed = 0;

        while(SubjectGroup::where('code', $result)->exists()){
            $result = bin2hex(random_bytes($length));
            $failed++;
            if($failed > 3){
                $length++;
            }
        }
        return $result;
    }

    public function subject()
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }

    public function users()
    {
        return $this->hasMany('App\SubjectGroupUser', 'group_id', 'id');
    }

    public function owner()
    {
        return $this->subject->user;
    }

    public function tasks()
    {
        return $this->hasMany('App\Task', 'group_id', 'id');
    }

    public function path()
    {
        return $this->subject->path() . '/' . $this->id;
    }
}
