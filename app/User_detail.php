<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_detail extends Model
{
    //
    protected $fillable = [
    	'uid','headpic','desc','Occupation'
    ];

    public function User(){
    	return $this->belongsTo('App\User');
    }

}
