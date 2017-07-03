<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $table = "stats";
    protected $fillable = ['article_id'];
    public  $timestamps = false;
    public function article()
    {
    	return $this->belongsTo('App\Article');
    }
}
