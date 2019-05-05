<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ownedSubjects()
    {
        return $this->hasMany('App\Subject');
    }

    public function subjectGroupUser()
    {
        return $this->hasMany('App\SubjectGroupUser');
    }

    public function subjects()
    {
        return $this->subjectGroupUser()->with('group.subject');
    }

    public function isLecturer()
    {
        return $this->type == 1;
    }

    public function isStudent()
    {
        return $this->type == 0;
    }
}
