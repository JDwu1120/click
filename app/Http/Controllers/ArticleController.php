<?php
/**
 * Created by PhpStorm.
 * User: 111
 * Date: 2016/11/27
 * Time: 22:15
 */

namespace App\Http\Controllers;
use App\dto\Operate;
use App\Service\Imploment\AdminService;
use App\Service\Imploment\LoginService;
use App\Service\Imploment\ArticleService;
use Illuminate\Http\Request;
use App\Service\Imploment\UserService;
class ArticleController extends Controller
{
    private $log;
    private $art;
    private $user;
    public function __construct()
    {
        $this->log = new LoginService();
        $this->art = new ArticleService();
        $this->user = new UserService();
    }
    /*
     * 显示所有文章
     */
    public function showArticle(Request $request){
        $token = $request->input('token');
        $page = $request->input('page');
        $data = $this->art->showArticle($page);
        $log = $this->log->checkLog($token);
        if ($log){
            $data['userInfo'] = $this->user->getInfo($token);
        }
        $mes = new Operate(true,'',$log,$data);
        echo json_encode($mes);
    }
    /*
     * 显示某个文章
     */
    public function showOneArticle(Request $request){
        $token = $request->input('token');
        $data = $this->art->showOneArticle($request->input('id'));
        $data['comments'] = $this->art->showComment($request->input('id'));
        if (!$data['comments']){
            $data['comments']=null;
        }
        $log = $this->log->checkLog($token);
        if ($log){
            $data['userInfo'] = $this->user->getInfo($token);
        }
        $msg = new Operate(true,'',$log,$data);
        return json_encode($msg);
    }
    /*
     * 查询文章
     */
    public function queryArticle(Request $request){
        $title = $request->input('title');
        $token = $request->input('token');
        $msg = $this->art->queryArticle($title);
        $log = $this->log->checkLog($token);
        if ($log){
            $msg['userInfo'] = $this->user->getInfo($token);
        }
        $data = new Operate(true,'',$log,$msg);
        return json_encode($data);
    }
    /*
     * 主页信息
     * 推荐文章
     * 最新文章
     * 标签显示
     * 分类显示
     */
    public function homepage(Request $request){
        $token = $request->input('token');
        $data['featureArticle'] = $this->art->featureArticle();
        $data['latestArticle'] = $this->art->latestArticle();
        $data['tag'] = $this->art->showTag();
        $data['category'] = $this->art->showCategory();
        $data['news'] = AdminService::showNews();
        $log = $this->log->checkLog($token);
        if ($log){
            $data['userInfo'] = $this->user->getInfo($token);
        }
        $msg = new Operate(true,'',$log,$data);
        return json_encode($msg);
    }
    /*
     * 浏览文章
     */
    public function viewArticle(Request $request)
    {
        $id = $request->input('id');
        $token  = $request->input('token');
        $user = new UserService();
        $res = $user->viewArticle($id);
        $res['comments'] = $this->art->showComment($id);
        if (!$res['comments']){
            $res['comments']=array();
        }
        $log = $this->log->checkLog($token);
        if ($log){
            $res['userInfo'] = $this->user->getInfo($token);
        }
        $msg = new Operate(true,'success',$log,$res);
        return json_encode($msg);
    }
    /*
     * 按分类显示一类文章
     */
    public function showOneCategory(Request $request){
        $category = $request->input('category');
        $page = $request->input('page');
        $token  = $request->input('token');
        $res = $this->art->showOneCategory($category,$page);
        $log = $this->log->checkLog($token);
        if ($log){
            $res['userInfo'] = $this->user->getInfo($token);
        }
        $msg = new Operate(true,'',$log,$res);
        return json_encode($msg);
    }
    /*
     * 按标签显示一类文章
     */
    public function showOneTag(Request $request){
        $tag = $request->input('tag');
        $page = $request->input('page');
        $token  = $request->input('token');
        $res = $this->art->showOneTag($tag,$page);
        $log = $this->log->checkLog($token);
        if ($log){
            $res['userInfo'] = $this->user->getInfo($token);
        }
        $msg = new Operate(true,'',$log,$res);
        return json_encode($msg);
    }
}