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

class ArticleRepository {

	//发表文章
    public function store($request){
        	$article = [];
  		if($request->article['pic'] == ''){
  			$article['pic'] = '0';
  		}else{
  			$article['pic'] = $request->article['pic'];	
  		}
    	$article['article'] = $request->article['html'];
    	$article['title'] = $request->article['title'];
    	
     	$top = $request->article['topicid'];
     	$article['topicid'] = implode('/',$top);
     	$article['uid'] = $request->user()['id'];
        
        // return
        if(Article::create($article)){
	    	for($i =0 ;$i<count($top);$i++){
          Topic::findOrFail($top[$i])->increment('article_count');
        }
        User::findOrFail($request->user()['id'])->increment('article_count');
        return '1';
        }else{
          return '0';
        };     
        //有时间把base64改成文件上传到服务器,base64拖慢网页加载,并且数据库查询较慢
    }
    
    //判断文章是否点过赞，遍历出topic
    public function pd($data) {
      //分割字符串为数组并查询topic表中的数据然后返给data 再传递到前台
      if(count($data) == 1){
        $topic = explode('/',$data->topicid);
        for($n=0;$n<count($topic);$n++){
          $newData['topicid'][] = Topic::find($topic[$n]);
          $data['topic'] = $newData['topicid'];
        }
        $data['isAgree'] = User_article_agrees::where('uid',Auth::id())->where('article_id',$data['id'])->first();
        $data['isCollection'] = User_collection::where('uid',Auth::id())->where('cid',$data['id'])->first();
        return $data;
      }else{
        for($i=0;$i<count($data);$i++){
          $topic = explode('/',$data[$i]->topicid);
          for($n=0;$n<count($topic);$n++){
            $newData['topicid'][$i][] = Topic::find($topic[$n]);
            $data[$i]['topic'] = $newData['topicid'][$i];
          }
          $data[$i]['isAgree'] = User_article_agrees::where('uid',Auth::id())->where('article_id',$data[$i]['id'])->first();
          $data[$i]['isCollection'] = User_collection::where('uid',Auth::id())->where('cid',$data[$i]['id'])->first();
          $data[$i]['user'] = User::leftJoin('User_details','users.id','=','user_details.uid')->where('users.id',$data[$i]['uid'])->first();
        }
        return $data;
      }
    }

    public function getAll(){
      $data = Article::limit('10')->where('is_delete','0')->get();
      return $this->pd($data);
      
    }

    public function agree($request){

       if($request->user()['id'] == ''){
          return '2';
          exit;
       }

       if(User_article_agrees::where('uid',$request->user()['id'])->where('article_id',$request->get('id'))->count() > 0){
          // 取消赞
          User_article_agrees::where('uid',$request->user()['id'])->where('article_id',$request->get('id'))->delete();
          Article::findOrFail($request->get('id'))->decrement('agree_count');

          return '0';
       }else{
          //点赞
          $data['uid'] = $request->user()['id'];
          $data['article_id'] = $request->get('id');
          if(User_article_agrees::create($data)){
            Article::findOrFail($request->get('id'))->increment('agree_count');
            return '1';
          }

       };
    }


    public function getOne($request) {

      $data = Article::findOrFail($request->get('id'));
      $topic = explode('/',$data->topicid);
      for($n=0;$n<count($topic);$n++){
        $newData['topicid'][] = Topic::find($topic[$n]);
        $data['topic'] = $newData['topicid'];
      }
      $data['isAgree'] = User_article_agrees::where('uid',Auth::id())->where('article_id',$data['id'])->first();
      $data['isCollection'] = User_collection::where('uid',Auth::id())->where('cid',$data['id'])->first();
      $data['user'] = User::findOrFail($data['uid']);
      $data['userdetail'] = User_detail::where('uid',$data['uid'])->first();
      return $data;

    }

    public function collection($request){

      if(Auth::id()){
         $pd = User_collection::where('cid',$request->get('id'))->where('uid',Auth::id())->where('collection_type','article')->first();

        if(!$pd){
         
            $data['uid'] = Auth::id();
            $data['cid'] = $request->get('id');
            $data['collection_type'] = 'article';
            $data = User_collection::create($data);
            return '1';
            return '2';
          
        }else{
          User_collection::where('cid',$request->get('id'))->where('collection_type','article')->where('uid',Auth::id())->delete();
          return '0';
        }
      }else{
        return '2';
      }

     

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
            Article::findOrFail($request->tid)->increment('comment_count');
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


    public function getComment($request){
      $data = Comments::where('comment_type','article')->where('tid',$request->get('tid'))->get();
      foreach($data as $k=>$v){
        $from_user = User::findOrFail($data[$k]['from_id']);
        $data[$k]['from_user'] = $from_user;
        $data[$k]['from_user_headpic'] = User_detail::where('uid',$from_user['id'])->select('headpic')->first()['headpic'];
        if($data[$k]['to_id'] != 0){
          $data[$k]['to_user'] = User::findOrFail($data[$k]['to_id']);
        };

        $data[$k]['isAgree'] = User_agree_comment::where('uid',Auth::id())->where('comment_type','article')->where('tid',$data[$k]['id'])->first();
      }
      return $data;
    }

    public function commentAgree($request){
      
      if(Auth::id()){

        if(User_agree_comment::where('tid',$request->get('id'))->where('uid',Auth::id())->where('comment_type','article')->get()->count() > 0){
          Comments::findOrFail($request->get('id'))->decrement('agree_count');
          User_agree_comment::where('tid',$request->get('id'))->where('uid',Auth::id())->first()->delete();
          return '0';
        }else{
          $data['uid'] = Auth::id();
          $data['tid'] = $request->get('id');
          $data['comment_type'] = 'article';
          User_agree_comment::create($data);
          Comments::findOrFail($request->get('id'))->increment('agree_count');
          return '1';
        }
      }else{
        return '2';
      }
    }

    //评论删除
    public function commentDel($request){
      $statu1= Article::findOrFail($request->tid)->decrement('comment_count');
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

    //文章删除
    public function delete($request){
      if(!Auth::id()) return '2';
      $statu1 = Article::where('id',$request->get('id'))->update(['is_delete'=>'1']);
      $statu = User::findOrFail(Auth::id())->decrement('article_count');
      if($statu1 && $statu) return '1';
    }

    //编辑文章
    public function edit($request){
      $data['topicid'] = implode('/',$request->article['topicid']);
      $data['pic'] = $request->article['pic'];
      $data['title'] = $request->article['title'];
      $data['article'] = $request->article['html'];

      if(Article::where('id',$request->article['id'])->update($data)){
        return '1';
      }else{
        return '0';
      };
    }
}

?>