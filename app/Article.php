<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class Article extends Model
{
    //
    protected $fillable = [
        'title', 'article', 'uid','pic','topicid'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function topic(){
    	return $this->hasMany('App\Topic');
    }
    
    public function user_article_agrees(){
        return $this->hasMany('App\User_article_agrees');
    }


}
