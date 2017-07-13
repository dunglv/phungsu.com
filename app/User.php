<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function articles()
    {
        return $this->hasMany('App\Article', 'id');
    }

    public function comments()
    {
        return $this->belongsToMany('App\Comment', 'article_comment');
    }

    public function isAdmin()
    {
        // dd($this)
        return (int)$this->auth === 1;
    }

    public function active_users()
    {
        return $this->hasMany('App\ActiveUser', 'user_id');
    }
}
