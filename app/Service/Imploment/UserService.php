<?php

/**
 * Created by PhpStorm.
 * User: 111
 * Date: 2016/11/27
 * Time: 17:13
 */
namespace App\Service\Imploment;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use App\Service\UserInterface;
use App\Models\Article;
class UserService implements UserInterface
{
    private $log;
    private $usr;
    private $art;
    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->log = new LoginService();
        $this->usr = new UserRepository();
        $this->art = new ArticleRepository();
    }
    /*
     * 储存文章
     */
    public function addArticle($arr)
    {
        $res = ArticleRepository::addArticle($arr);
        return $res;
    }
    /*
     * 浏览文章接口
     */
    public function viewArticle($id)
    {
        // TODO: Implement viewArticle() method.
        $mes = ArticleRepository::viewArticle($id);
        return $mes;
    }
    /*
     * 收藏文章
     */
    public function colArticle($id,$userName)
    {
        // TODO: Implement colArticle() method.
            $is = self::isCollection($id,$userName);
            //返回ture表示未被收藏
            if ($is->getState()){
                $data = ArticleRepository::colArticle($id,$userName);
                if ($data)
                {
                    $mes = $data;
                }else{
                    $mes = '收藏失败!';
                }
            }else{
                $mes = '您已经收藏过该文章';
            }
        return $mes;
    }
    /*
     * 收藏列表
     */
    public function collectionList($userName)
    {
        // TODO: Implement collectionList() method.
            $data = ArticleRepository::collectionList($userName);
            if (empty($data)){
                $mes = '您没有收藏';
            }else{
                $mes = $data;
            }
        return $mes;
    }

    /*
     * 判断文章是否被收藏过
     */
    public function isCollection($id, $userName)
    {
        // TODO: Implement isCollection() method.
            $data = ArticleRepository::isCollection($id,$userName);
            if (empty($data)){
                $mes = $data;
            }else{
                $mes = '您已经收藏过该文章';
            }
        return $mes;
    }
    /*
     * 取消收藏
     */
    public function delCollection($id,$userName)
    {
        // TODO: Implement delCollection() method.
        $is = $this->isCollection($id,$userName);
        if (!empty($is)){
            $mes = ArticleRepository::delCollection($id,$userName);
        }else{
            $mes = '您未收藏过该文章';
        }
        return $mes;
    }
    /*
     * 留言评论
     */
    public function comment($aid,$userName,$content,$power,$token)
    {
        // TODO: Implement comment() method.
        $res = $this->art->comment($aid,$userName,$content,$power,$token);
        return $res;
    }
    public function delComment($id, $aid, $userName)
    {
        // TODO: Implement delComment() method.
            $res = ArticleRepository::delComment($id,$aid,$userName);
            if ($res){
                $mes = $res;
            }else{
                $mes = '删除失败';
            }
        return $mes;
    }
    //获取用户信息
    public function getInfo($token){
        $info = $this->usr->getInfo($token);
        if ($info){
            return $info;
        }else{
            return false;
        }
    }
}



