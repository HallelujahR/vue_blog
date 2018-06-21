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

    public function getAll(){
        $data = $this->QuestionRepository->getAll();
        return $data;
    }

    public function createQuestion(Request $request){
    	$this->validate($request, [
	        $request->question['title'] => 'min:2',
     	]);

    	$status = $this->QuestionRepository->store($request);
    	return $status;
    }

    public function detail(){
        return view('question.detail');
    }

    public function getDetail(Request $request){
        $data = $this->QuestionRepository->getDetail($request);
        return $data;
    }

    public function follow(Request $request){
        $statu = $this->QuestionRepository->follow($request);

        return $statu;
    }

    public function comment(Request $request){
        $statu = $this->QuestionRepository->comment($request);
        return $statu;

    }

    public function getComment(Request $request){
        $data = $this->QuestionRepository->getComment($request);
        return $data;
    }

    public function commentDel(Request $request){
        $statu = $this->QuestionRepository->commentDel($request);
        return $statu;
    }

    public function commentAgree(Request $request){
        $statu = $this->QuestionRepository->commentAgree($request);
        return $statu;
    }
}
