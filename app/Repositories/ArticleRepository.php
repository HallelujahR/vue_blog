<?php

namespace App\Repositories;
use App\Article;
use App\Topic;

class ArticleRepository {

	//发表文章
    public function store($request){
    // 	$article = [];

  		// $article['pic'] = $request->article['pic'];
    // 	$article['article'] = $request->article['html'];
    // 	$article['title'] = $request->article['title'];
    	
    //  	$top = $request->article['topicid'];
    //  	$article['topicid'] = implode('/',$top);
    //  	$article['uid'] = $request->user()['id'];
        
    //     // return
    //     if(Article::create($article)){
	   //  	for($i =0 ;$i<count($top);$i++){
	   //  		Topic::findOrFail($top[$i])->increment('article_count');
	   //  	}
    //  		return '1';
    //     }else{
    //     	return '0';
    //     };	   
    	return '1';
    }
		    

}

?>