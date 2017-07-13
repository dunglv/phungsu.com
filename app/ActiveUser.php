<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveUser extends Model
{
    protected $table = 'active_user';
    protected $fillable = ['key'];

    public function user()
     {
     	return $this->belongsTo('App\User', 'user_id')->withTimestamps();
     } 
}
