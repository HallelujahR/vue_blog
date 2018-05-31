<?php

namespace App\Repositories;
use App\Question;
use App\Topic;
use App\User;

class QuestionRepository {

	//发表问题
    public function store($request){
        $question = [];

        $question['desc'] = $request->question['html'];
        $question['title'] = $request->question['title'];
        
        $top = $request->question['topicid'];
        $question['topicid'] = implode('/',$top);
        $question['uid'] = $request->user()['id'];
        
        // return
        if(Question::create($question)){
            for($i =0 ;$i<count($top);$i++){
                Topic::findOrFail($top[$i])->increment('question_count');
            }
            return '1';
        }else{
            return '0';
        };     
    }
		    

}

?>