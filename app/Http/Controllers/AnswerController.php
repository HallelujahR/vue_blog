<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AnswerRepository;

class AnswerController extends Controller
{
    //
   	protected $AnswerRepository;

    public function __construct(AnswerRepository $AnswerRepository){
    	$this->AnswerRepository = $AnswerRepository;
    }

    public function store(Request $request) {
    	$statu = $this->AnswerRepository->create($request);
    	return $statu;
    }

    public function getAnswer(Request $request) {
    	$data = $this->AnswerRepository->getAnswer($request);
    	return $data;
    	
    }
}
