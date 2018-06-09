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

    public function getAll(){
        $data = $this->ArticleRepository->getAll();
        return $data;
    }

    public function agree(request $request){
        $statu = $this->ArticleRepository->agree($request);
        return $statu;
    }

    public function detail(request $request){
        
        return view('article.Detail');
    }

    public function getArticleDetail(request $request) {
        $data = $this->ArticleRepository->getOne($request);
        return $data;
    }

    public function collection(request $request){
        $statu = $this->ArticleRepository->collection($request);
        
        return $statu;
    }

    public function comment(request $requests){
        $statu = $this->ArticleRepository->comment($requests);
        return $statu;
    }
}

