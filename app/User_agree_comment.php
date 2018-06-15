<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_agree_comment extends Model
{
    //
    protected $fillable = [
    	'tid','comment_type','uid'
    ];

    public function User(){
    	return $this->belongsTo('App\User');
    }

    public function Comment(){
    	return $this->belongsTo('App\Comment');
    }
}
