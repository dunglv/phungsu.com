<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    public function article()
    {
    	return $this->belongsToMany('App\Article', 'article_category', 'category_id', 'article_id');
    }
}
