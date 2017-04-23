<?php

namespace App\Http\Controllers;

use App\dto\Operate;
use App\Service\Imploment\AdminService;
use App\Service\Imploment\ArticleService;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminController extends Controller
{
    private $admin;
    private $art;
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->admin = new AdminService();
        $this->middleware('adminCheck');
        $this->art = new ArticleService();
    }
    public function addNews(Request $request){
        $message = [
            'admin' => $request->input('admin'),
            'title' => $request->input('title'),
            'message' => $request->input('message')
        ];
        $res = $this->admin->addNews($message);
        if ($res){
            return;
        }else{
            return;
        }
    }
    /*
     * 删除文章
     */
    public function delArticle(Request $request){
        $id = $request->input('id');
        $data = $this->art->delArticle($id);
        $msg = new Operate(true,'',1,$data);
        return json_encode($msg);
    }
    /*
     * 修改指定文章
     */
    public function editArticle(Request $request){
        $id = $request->input('id');
        $ArticleInfo = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'category' => $request->input('category'),
            'tag' => $request->input('tag'),
        ];
        $data = $this->art->editAticle($id,$ArticleInfo);
        $msg = new Operate(true,'',1,$data);
        return json_encode($msg);
    }
}
