<?php
/**
 * Created by PhpStorm.
 * User: 111
 * Date: 2016/11/27
 * Time: 22:13
 */

namespace App\Service\Imploment;
use App\dto\Operate;
use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Service\ArticleInterface;

class ArticleService implements ArticleInterface
{
    public static function addArticle($arr)
    {
        // TODO: Implement addArticle() method.
        //写入文章
        if (UserService::checkLog()) {
            $arr1 = [
                'title' => 'test',
                'article' => $arr['article'],
                'userName' => 'admina0pppq',
                'tag1' => 'test1',
                'tag2' => 'test2',
                'tag3' => 'test3',
                'tag4' => 'test4',
                'tag5' => 'test5',
                'power'=> $arr['power'],
            ];
            $res = ArticleRepository::addArticle($arr1);
            if ($res){
                $mes = new Operate(true,1001,$res);
            }else{
                $mes = new Operate(false,1003,'保存失败!');
            }
        }else{
            $mes = new Operate(false,1002,'请先登录!');
        }
        return $mes;
    }
    /*
     * 文章图片储存
     */
    public static function articleImg($arr)
    {
        // TODO: Implement articleImg() method.
        if (UserService::checkLog()){
            $res = ArticleRepository::articleImg($arr);
            if ($res){
                $mes = new Operate(true,1001,$res);
            }else{
                $mes = new Operate(false,1003,'保存失败');
            }
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return json_encode($mes);
    }
    /*
     * 显示所有文章
     */
    public static function showArticle()
    {
        // TODO: Implement showArticle() method.
        if (UserService::checkLog()){
            $data = ArticleRepository::showArticle();
            $mes = new Operate(true,1001,$data);
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }
    /*
     * 显示指定文章
     */
    public static function showOneArticle($id)
    {
        if (UserService::checkLog()){
            $mes = new Operate(true,1001,ArticleRepository::showOneArticle($id));
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }
    /*
     * 删除指定文章
     */
    public static function delArticle($id)
    {
        // TODO: Implement delArticle() method.
        if (UserService::checkLog()){
            $mes = new Operate(true,1001,ArticleRepository::delArticle($id));
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }
    /*
     * 修改指定文章
     */
    public static function editAticle($id,$content)
    {
        // TODO: Implement editAticle() method.
        if (UserService::checkLog()){
            $mes = new Operate(true,1001,ArticleRepository::editArticle($id,$content));
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }
    /*
     * 查询文章
     */
    public static function queryAticle($title)
    {
        // TODO: Implement queryAticle() method.
        if (UserService::checkLog()){
            $mes = new Operate(true,1001,ArticleRepository::queryArticle($title));
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }
    /*
     * 推荐文章
     */
    public function featureArticle()
    {
        // TODO: Implement featureArticle() method.
        $art = new ArticleRepository();
        if (UserService::checkLog()){
            $mes = new Operate(true,1001,$art->featureArticle());
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }
    /*
     * 最新文章
     */
    public function latestArticle()
    {
        // TODO: Implement featureArticle() method.
        $art = new ArticleRepository();
        if (UserService::checkLog()){
            $mes = new Operate(true,1001,$art->latestArticle());
        }else{
            $mes = new Operate(false,1002,'请先登录！');
        }
        return $mes;
    }
    /*
     * 标签显示
     */
    public function showTag()
    {
        // TODO: Implement showTag() method.
        $art = new ArticleRepository();
        $data = $art->showTag();
        $mes = new Operate(true,1001,$data);
        return $mes;
    }
    /*
     * 分类显示
     */
    public function showCategory()
    {
        // TODO: Implement showCategory() method.
        $art = new ArticleRepository();
        $data = $art->showCategory();
        $mes = new Operate(true,1001,$data);
        return $mes;
    }
}