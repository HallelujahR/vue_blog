<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_article_agrees extends Model
{
    //

    protected $fillable = [
    	'uid','article_id'
    ];

	public function Article(){
		return $this->belongsTo('App\Article');
	}    
}
