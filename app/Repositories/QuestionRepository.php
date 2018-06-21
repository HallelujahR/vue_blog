<?php

namespace App\Repositories;
use App\Question;
use App\Topic;
use App\User;
use App\User_collection;
use App\Comments;
use Auth;
use App\User_detail;
use App\User_agree_comment;

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
            User::findOrFail($request->user()['id'])->increment('question_count');
            return '1';
        }else{
            return '0';
        };     
    }

    //获取所有问题
    public function getAll(){
        $data = Question::limit('10')->where('is_delete','0')->get();
        return $this->pd($data);
    }

    //判断文章是否点过赞，遍历出topic
    public function pd($data) {
      //分割字符串为数组并查询topic表中的数据然后返给data 再传递到前台

        for($i=0;$i<count($data);$i++){
          $topic = explode('/',$data[$i]->topicid);
          for($n=0;$n<count($topic);$n++){
            $newData['topicid'][$i][] = Topic::find($topic[$n]);
            $data[$i]['topic'] = $newData['topicid'][$i];
          }
         
          $data[$i]['user'] = User::leftJoin('User_details','users.id','=','user_details.uid')->where('users.id',$data[$i]['uid'])->first();
        }
        return $data;
    }

    public function getDetail($request){
        $data = Question::where('id',$request->post('id'))->get();
        $count = User_collection::where('cid',$request->post('id'))->where('collection_type','question')->where('uid',Auth::id())->get()->count();
        if($count > 0){
            $data[0]['is_collection'] = '1';
        }else{
            $data[0]['is_collection'] = '0';
        }
        return $this->pd($data)[0];

    }

    public function follow($request){

        if(Auth::id()){
            $pd = User_collection::where('cid',$request->get('id'))->where('uid',Auth::id())->where('collection_type','question')->first();
            if(!$pd){
                $data['uid'] = Auth::id();
                $data['cid'] = $request->get('id');
                $data['collection_type'] = 'question';
                $data = User_collection::create($data);
                Question::findOrFail($request->get('id'))->increment('follow_count');
                return '1';
            }else{
                User_collection::where('cid',$request->get('id'))->where('uid',Auth::id())->where('collection_type','question')->delete();
                Question::findOrFail($request->get('id'))->decrement('follow_count');
                return '0';
            }

        }else{
            return '2';
        }


    }
//--------------------------------------------- 
    public function getComment($request){

          $data = Comments::where('comment_type','question')->where('tid',$request->get('tid'))->get();
      foreach($data as $k=>$v){
        $from_user = User::findOrFail($data[$k]['from_id']);
        $data[$k]['from_user'] = $from_user;
        $data[$k]['from_user_headpic'] = User_detail::where('uid',$from_user['id'])->select('headpic')->first()['headpic'];
        if($data[$k]['to_id'] != 0){
          $data[$k]['to_user'] = User::findOrFail($data[$k]['to_id']);
        };

        $data[$k]['isAgree'] = User_agree_comment::where('uid',Auth::id())->where('comment_type','question')->where('tid',$data[$k]['id'])->first();
      }
      return $data;      

    }

    public function comment($request){

      if(Auth::id()){
        $content = $request->content;
        if(strlen(preg_replace('/\s+/', '', $content)) == 0){
          //判断输入的是否是空格
          return '3';
        }else{
          //判断是否成功
          $data['to_id'] = $request->to_id;
          $data['content'] = $content;
          $data['from_id']= Auth::id();
          $data['tid']= $request->tid;
          $data['comment_type']= $request->comment_type;
          $statu = Comments::create($data);          
          if($statu){
            Question::findOrFail($request->tid)->increment('comment_count');
            $user = User::leftJoin('User_details','users.id','=','user_details.uid')->where('users.id',Auth::id())->first();
            $user['content'] = $statu['content'];
            $user['cid'] = $statu['id'];
            $user['tid'] = $request->tid;
            $user['to_user'] =User::leftJoin('User_details','users.id','=','user_details.uid')->where('users.id',$request->to_id)->first();
            return $user;
          }else{
            return '0';
          }
        };
      }else{
        //判断是否登录
        return '2';
      };

    }

    public function commentDel($request){
      $statu1= Question::findOrFail($request->tid)->decrement('comment_count');
      $statu2 = Comments::find($request->id)->delete();
      $statu = User_agree_comment::where('uid',Auth::id())->where('tid',$request->id)->get()->count();
      if($statu > 0){
        User_agree_comment::where('tid',$request->id)->first()->delete();
      };
      if($statu1 && $statu2){
        return '1';
      }else{
        return '0';
      }

    }

    public function commentAgree($request){
      
      if(Auth::id()){

        if(User_agree_comment::where('tid',$request->get('id'))->where('uid',Auth::id())->where('comment_type','question')->get()->count() > 0){
          Comments::findOrFail($request->get('id'))->decrement('agree_count');
          User_agree_comment::where('tid',$request->get('id'))->where('uid',Auth::id())->first()->delete();
          return '0';
        }else{
          $data['uid'] = Auth::id();
          $data['tid'] = $request->get('id');
          $data['comment_type'] = 'question';
          User_agree_comment::create($data);
          Comments::findOrFail($request->get('id'))->increment('agree_count');
          return '1';
        }
      }else{
        return '2';
      }
    }



		    

}

?>