<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2016/12/20
 * Time: 下午8:19
 */

namespace App\Http\Controllers;


use App\dto\Operate;
use App\Service\Imploment\ArticleService;
use App\Service\Imploment\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * UserController constructor.
     */
    public $usr;
    public $art;
    public function __construct()
    {
        $this->usr=new UserService();
        $this->art=new ArticleService();
    }
    /*
     * 添加文章
     */
    public function addArticle(Request $request)
    {
        $ArticleInfo = [
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'article' => $request->input('article'),
            'userName' => $request->input('userName'),
            'tag' =>   $request->input('tag'),
            'power' =>  $request->input('power'),
        ];
        $data = $this->usr->addArticle($ArticleInfo);
        $msg = new Operate(true,'',1,$data);
        return json_encode($msg);
    }
    /*
     * 添加图片
     */
    public function articleImg(Request $request)
    {
        $arr = [
            "userName" => $request->input('userName'),
            "original" => $request->input('original'),
            "size"     => $request->input('size'),
            "type"     => $request->input('type'),
            "url"      => $request->input('url')
        ];
        $data = $this->art->articleImg($arr);
        $msg = new Operate(true,'',1,$data);
        return json_encode($msg);
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
    /*
     * 收藏文章
     */
    public function colArticle(Request $request)
    {
        $id = $request->input('id');
        $userName = $request->input('userName');
        $res = $this->usr->colArticle($id,$userName);
        $msg = new Operate(true,'',1,$res);
        return json_encode($msg);
    }
    /*
     * 收藏列表
     */
    public function collectionList(Request $request)
    {
        $userName = $request->input('userName');
        $res = $this->usr->collectionList($userName);
        $msg = new Operate(true,'',1,$res);
        return json_encode($msg);
    }
    /*
     * 检查文章是否被收藏过
     */
    public function isCollection(Request $request)
    {
        $id = $request->input('id');
        $userName = $request->input('userName');
        $res = $this->usr->isCollection($id,$userName);
        $msg = new Operate(true,'',1,$res);
        return json_encode($msg);
    }
    /*
     * 删除收藏
     */
    public function delCollection(Request $request)
    {
       $id = $request->input('id');
       $userName = $request->input('userName');
       $res = $this->usr->delCollection($id,$userName);
       $msg = new Operate(true,'',1,$res);
       return json_encode($msg);
    }
    /*x
     * 评论留言
     */
    public function comment(Request $request)
    {
        $aid = $request->input('aid');
        $userName = $request->input('userName');
        $comment = $request->input('content');
        $power = $request->input('power');
        $res = $this->usr->comment($aid,$userName,$comment,$power);
        $msg = new Operate(true,'',1,$res);
        return json_encode($msg);
    }
    /*
     * 删除留言评论
     */
    public function delComment(Request $request)
    {
        $id = $request->input('id');
        $aid = $request->input('aid');
        $userName = $request->input('userName');
        $res = $this->usr->delComment($id,$aid,$userName);
        $msg = new Operate(true,'',1,$res);
        return json_encode($msg);
    }
    /*
     * 获取用户信息
     */
    public function getInfo(Request $request){
        $token = $request->input('token');
        $info = $this->usr->getInfo($token);
        if ($info){
            $msg = new Operate(true,'',1,$info);
        }else{
            $msg = new Operate(true,'',0,$info);
        }
        return json_encode($msg);
    }
}
