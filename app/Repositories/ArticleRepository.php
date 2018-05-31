<?php

namespace App\Repositories;
use App\Article;
use App\Topic;

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
	    	User::findOrFail($request->user()['id'])->increment('question_count');
     		return '1';
        }else{
        	return '0';
        };	   
        //有时间把base64改成文件上传到服务器,base64拖慢网页加载,并且数据库查询较慢
    }
		    

}

?>