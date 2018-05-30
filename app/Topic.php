<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //
    protected $fillable = [
        'topic','uid'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function article(){
    	return $this->hasMany('App\Article');
    }
}
