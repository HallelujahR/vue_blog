<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function Index() {
    	return view('article.Index');
    }

    public function test(){
    	return 'ok';
    }

    public function createArticle(Request $request){
    	dump($request);
    }
}

