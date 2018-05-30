<?php

namespace App\Http\Controllers;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    protected $ArticleRepository;

    public function __construct(ArticleRepository $ArticleRepository){
    	$this->ArticleRepository = $ArticleRepository;
    }

    public function Index() {
    	return view('article.Index');
    }

    public function test(){
    	return 'ok';
    }

    public function createArticle(Request $request){
    	$status = $this->ArticleRepository->store($request);
    	return $status;
    }
}

