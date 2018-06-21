<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $fillable = [
    	'content','uid','comment_count','agree_count','qid'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function question(){
    	return $this->belongsTo('App\question');
    }


}
