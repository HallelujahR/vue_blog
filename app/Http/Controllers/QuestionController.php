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
    	return view('question.Index');
    }

    public function test(){
    	return 'ok';
    }

    public function createQuestion(Request $request){
    	$this->validate($request, [
	        $request->question['title'] => 'min:2',
     	]);

    	$status = $this->QuestionRepository->store($request);
    	return $status;
    }

}
