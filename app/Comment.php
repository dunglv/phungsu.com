<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";

    public function article()
    {
    	return $this->belongsToMany('App\Article');
    }
}
