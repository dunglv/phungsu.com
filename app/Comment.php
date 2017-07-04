<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";

    public function user()
    {
    	return $this->belongsToMany('App\User',  'article_comment');
    }

    public function article()
    {
    	return $this->belongsToMany('App\Article');
    }

    public function children($parent)
    {
    	$comments = $this->where('parent', $parent)->get();
    	return $comments;
    }
}
