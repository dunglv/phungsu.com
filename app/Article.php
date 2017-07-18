<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = "articles";

    public function category()
    {
    	return $this->belongsToMany('App\Category');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function tags()
    {
    	return $this->belongsToMany('App\Tag');
    }

    public function stat()
    {
        return $this->hasOne('App\Stat');
    }

    public function comments()
    {
        return $this->belongsToMany('App\Comment', 'article_comment', 'article_id', 'comment_id');
    }
}
