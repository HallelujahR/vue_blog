<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TopicRepository;

class TopicController extends Controller
{
    protected $TopicRepository;
	public function __construct(TopicRepository $TopicRepository){
		$this->Repositories = $TopicRepository;
	}

    public function getTopic(Request $request){

    	if($request->topic != ''){
	    	$topic = $this->Repositories->getTopic($request->topic);
	    	return $topic;
    	}else{
    		$array = [];
    		return $array;
    	}
    }
}
