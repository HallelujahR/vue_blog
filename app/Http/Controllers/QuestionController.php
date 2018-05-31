<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //
    protected $QuestionRepository;

    public function __construct(QuestionRepository $QuestionRepository){
    	$this->QuestionRepository = $QuestionRepository;
    }

    public function Index() {
    	return view('article.Index');
    }

    public function test(){
    	return 'ok';
    }

    public function createQuestion(Request $request){
    	$status = $this->QuestionRepository->store($request);
    	return $status;
    }

}
