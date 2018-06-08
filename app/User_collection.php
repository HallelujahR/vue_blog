<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_collection extends Model
{
    //
    protected $fillable = [
    	'uid','cid','collection_type'
    ];
}
