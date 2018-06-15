<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $fillable = [
    	'tid','comment_type','from_id','to_id','content'
    ];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function question(){
    	return $this->belongsTo('App\Question');
    }

    public function article() {
    	return $this->belongsTo('App\Article');
    }

    public function User_agree_comment(){
        return $this->hasMany('App\User_agree_comment');
    }
}
