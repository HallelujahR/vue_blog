<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = [
        'title', 'desc', 'uid','topicid'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function topic(){
    	return $this->hasMany('App\Topic');
    }

    public function comments(){
        return $this->hasMany('App\Comments');
    }

    public function anaswer(){
        return $this->hasMany('App\Answer');
    }

}
