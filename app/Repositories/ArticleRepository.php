<?php

namespace App\Repositories;
use App\Article;
use App\Topic;
use App\User;
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
		  
    public function getAll(){
      $data = Article::limit('10')->get();

      //分割字符串为数组并查询topic表中的数据然后返给data 再传递到前台
      for($i=0;$i<count($data);$i++){
        $topic = explode('/',$data[$i]->topicid);
        for($n=0;$n<count($topic);$n++){
          $newData['topicid'][$i][] = Topic::find($topic[$n]);
          $data[$i]['topic'] = $newData['topicid'][$i];
        }
      }
      return $data;
    }

    public function agree(){
      
    }

}

?>