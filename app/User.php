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

    /**
     * Get latest article of this user
     *
     * @return void
     * @author 
     **/
    public function latestArticle()
    {
        $a = Article::where('user_id', $this->id)->orderBy('id', 'desc')->first();
        if (count($a) > 0) {
            return $a;
        }else{
            return null;
        }
    }

    /**
     * Get latest comment of this user
     *
     * @return void
     * @author 
     **/
    public function latestComment()
    {
        $c = Comment::whereHas('user', function($q){
            $q->where('user_id', $this->id);
        })->orderBy('id', 'desc')->first();
        // dd($c->article[0]->id);
        if (count($c) > 0) {
            return $c;
        }else{
            return null;
        }
    }
}
