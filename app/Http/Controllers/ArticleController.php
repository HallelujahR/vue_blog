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

    public function getComment(request $request){
        $data = $this->ArticleRepository->getComment($request);
        return $data;
    }

    public function commentAgree(request $request){
        $data = $this->ArticleRepository->commentAgree($request);
        return $data;
    }

    public function commentDel(request $request){
        $data = $this->ArticleRepository->commentDel($request);
        return $data;
    }

    //文章删除
    public function delete(request $request){
        $statu = $this->ArticleRepository->delete($request);
        return $statu;
    }

    //修改文章
    public function edit(request $request){
        $statu = $this->ArticleRepository->edit($request);
        return $statu;
    }
}

