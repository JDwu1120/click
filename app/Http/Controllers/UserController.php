<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2016/12/20
 * Time: 下午8:19
 */

namespace App\Http\Controllers;


use App\Service\Imploment\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*
     * 检查登录
     */
    public static function checkLog(Request $request){
        UserService::getLogin();
    }
    /*
     * 浏览文章
     */
    public static function viewArticle(Request $request)
    {
        $id = $request->input('id');
        $userName = $request->input('userName');
        $res = UserService::viewArticle($id);
        return json_encode($res);
    }
    /*
     * 收藏文章
     */
    public static function colArticle(Request $request)
    {
        $id = $request->input('id');
        $userName = $request->input('userName');
        $res = UserService::colArticle($id,$userName);
        return json_encode($res);
    }
    /*
     * 收藏列表
     */
    public static function collectionList(Request $request)
    {
        $userName = $request->input('userName');
        $res = UserService::collectionList($userName);
        return json_encode($res);
    }
    /*
     * 检查文章是否被收藏过
     */
    public static function isCollection(Request $request)
    {
        $id = $request->input('id');
        $userName = $request->input('userName');
        $res = UserService::isCollection($id,$userName);
        return json_encode($res);
    }
    /*
     * 删除收藏
     */
    public static function delCollection(Request $request)
    {
       $id = $request->input('id');
       $userName = $request->input('userName');
       $res = UserService::delCollection($id,$userName);
        return json_encode($res);
    }
    /*
     * 评论留言
     */
    public static function comment(Request $request)
    {
        $aid = $request->input('aid');
        $userName = $request->input('userName');
        $comment = $request->input('content');
        $power = $request->input('power');
        $res = UserService::comment($aid,$userName,$comment,$power);
        return json_encode($res);
    }
    /*
     * 删除留言评论
     */
    public static function delComment(Request $request)
    {
        $id = $request->input('id');
        $aid = $request->input('aid');
        $userName = $request->input('userName');
        $res = UserService::delComment($id,$aid,$userName);
        return json_encode($res);
    }
}
