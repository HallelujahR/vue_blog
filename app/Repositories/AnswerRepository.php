<?php
namespace App\Repositories;
use App\Article;
use App\Topic;
use App\User;
use App\User_detail;
use App\User_article_agrees;
use App\Comments;
use Auth;
use App\User_collection;
use App\User_agree_comment;
use App\Question;
use App\Answer;

class AnswerRepository {

  public function create($request){
    if(strlen(strip_tags($request->post('content'))) == 0){
      return '3';
      exit;
    }

    $data['uid'] = Auth::id();
    $data['qid'] = $request->post('id');
    $data['content'] = $request->post('content');

    if(Auth::id()){
      if(Answer::create($data)){
        Question::findOrFail($request->post('id'))->increment('answer_count');
        return '1';
      }else{
        return '0';
      }
      
    }else{
      return '2';
    }

    
  }


  public function getAnswer($request){
      $data = Answer::leftjoin('User_details','Answers.uid','=','User_details.uid')->leftjoin('users','users.id','=','Answers.uid')->select('users.name','User_details.uid','User_details.headpic','User_details.desc','User_details.Occupation','Answers.*')->get();
    return $data;
  }

}

?>