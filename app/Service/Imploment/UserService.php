<?php

/**
 * Created by PhpStorm.
 * User: 111
 * Date: 2016/11/27
 * Time: 17:13
 */
namespace App\Service\Imploment;
use App\dto\Operate;
use App\Repositories\ArticleRepository;
use App\Service\UserInterface;
class UserService implements UserInterface
{
    /*
     * 检查用户是否登陆
     */
    public static function checkLog()
    {
        // TODO: Implement checkLog() method.
        if (1){
            return true;
        }
    }
    /*
     * 请求单点登录
     */
    public static function getToken()
    {
        // TODO: Implement getLog() method.
        $appkey = 'testappkey';
        $appsecretkey = 'testappsecretkey';
        $timestamp = time();
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for ( $i = 0; $i < 32; $i++ )
        {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        $hash = $password;
        $url = 'http://47.88.77.83:8080/sso/thrid/'.$appkey.'/'.$appsecretkey.'/'.$timestamp.'/'.$hash.'/access';
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        return $output;
    }
    public static function getLogin(){
        $res = self::getToken();
        $token = json_decode($res,true)['data']['token']['token'];
        $url = 'http://47.88.77.83:8080/sso/thrid/'.$token.'/getLogin';
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        return $output;
    }
    /*
     * 获取用户信息
     */
    public static function getUserInfo()
    {
        // TODO: Implement getUserInfo() method.
        return true;
    }
    /*
     * 浏览文章接口
     */
    public static function viewArticle($id)
    {
        // TODO: Implement viewArticle() method.
        if (self::checkLog()){
            $mes = new Operate(true,1001,ArticleRepository::viewArticle($id));
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }
    /*
     * 收藏文章
     */
    public static function colArticle($id,$userName)
    {
        // TODO: Implement colArticle() method.
        if (self::checkLog()){
            $is = self::isCollection($id,$userName);
            //返回ture表示未被收藏
            if ($is->getState()){
                $data = ArticleRepository::colArticle($id,$userName);
                if ($data)
                {
                    $mes = new Operate(true,1001,$data);
                }else{
                    $mes = new Operate(false,1003,'收藏失败！');
                }
            }else{
                $mes = new Operate(false,1003,'您已经收藏过该文章');
            }
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }
    /*
     * 收藏列表
     */
    public static function collectionList($userName)
    {
        // TODO: Implement collectionList() method.
        if (self::checkLog()){
            $data = ArticleRepository::collectionList($userName);
            if (empty($data)){
                $mes = new Operate(false,1003,'您没有收藏');
            }else{
                $mes = new Operate(true,1001,$data);
            }
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }

    /*
     * 判断文章是否被收藏过
     */
    public static function isCollection($id, $userName)
    {
        // TODO: Implement isCollection() method.
        if (self::checkLog()){
            $data = ArticleRepository::isCollection($id,$userName);
            if ($data==null){
                $mes = new Operate(true,1001,$data);
            }else{
                $mes = new Operate(false,1003,'您已经收藏过该文章');
            }
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }
    /*
     * 取消收藏
     */
    public static function delCollection($id,$userName)
    {
        // TODO: Implement delCollection() method.
        if(self::checkLog()){
        $is = self::isCollection($id,$userName);
        if (!$is->getState()){
            $mes = new Operate(true,1001,ArticleRepository::delCollection($id,$userName));
        }else{
            $mes = new Operate(false,1003,'您未收藏过该文章');
        }
    }else{
            $mes = new Operate(false,1002,'请先登录！');
    }
        return $mes;
    }
    /*
     * 留言评论
     */
    public static function comment($aid,$userName,$content,$power)
    {
        // TODO: Implement comment() method.
        if (self::checkLog()){
            $res = ArticleRepository::comment($aid,$userName,$content,$power);
            if ($res){
                $mes = new Operate($res,1001,'评论成功');
            }else{
                $mes = new Operate($res,1003,'评论失败');
            }
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }
    public static function delComment($id, $aid, $userName)
    {
        // TODO: Implement delComment() method.
        if (self::checkLog()){
            $res = ArticleRepository::delComment($id,$aid,$userName);
            if ($res){
                $mes = new Operate($res,1001,'删除成功');
            }else{
                $mes = new Operate($res,1003,'删除失败');
            }
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }
}