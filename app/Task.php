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

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function submissions()
    {
        if(auth()->user()->isStudent()) {
            return $this->hasMany('App\Submission')->where('user_id', auth()->id())->orderBy('created_at', 'desc');
        }
        return $this->hasMany('App\Submission')->orderBy('created_at', 'desc');
    }

    public function path()
    {
        return ($this->group->path() . '/' . $this->slug);
    }

    public function delete()
    {
        $this->submissions()->delete();
        return parent::delete();
    }

    public static function generateUniqueSlug($name)
    {
        $length = 1;
        $result = $name;
        $failed = 0;

        while(Task::where('slug', $result)->exists()){
            $result = $name . '-' .bin2hex(random_bytes($length));
            $failed++;
            if($failed > 3){
                $length++;
            }
        }
        return $result;
    }
}
