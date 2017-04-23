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
use App\Repositories\UserRepository;
use App\Service\ArticleInterface;

class ArticleService implements ArticleInterface
{
    public $art;
    public $usr;
    /**
     * ArticleService constructor.
     */
    public function __construct()
    {
        $this->art=new ArticleRepository();
        $this->usr=new UserRepository();
    }
    /*
     * 文章图片储存
     */
    public function articleImg($arr)
    {
            $res = ArticleRepository::articleImg($arr);
            if ($res){
                $mes = "保存成功";
            }else{
                $mes = "保存失败";
            }
        return json_encode($mes);
    }
    /*
     * 显示所有文章
     */
    public function showArticle($page)
    {
        // TODO: Implement showArticle() method.
        $data = ArticleRepository::showArticle($page);
        return $data;
    }
    /*
     * 显示指定文章
     */
    public function showOneArticle($id)
    {
        $mes = ArticleRepository::showOneArticle($id);
        ArticleRepository::viewArticle($id);
        return $mes;
    }
    /*
     * 删除指定文章
     */
    public function delArticle($id)
    {
        // TODO: Implement delArticle() method.
        $mes = ArticleRepository::delArticle($id);
        return $mes;
    }
    /*
     * 修改指定文章
     */
    public function editAticle($id,$content)
    {
        // TODO: Implement editAticle() method.
        $mes = ArticleRepository::editArticle($id,$content);
        return $mes;
    }
    /*
     * 查询文章
     */
    public function queryArticle($title)
    {
        // TODO: Implement queryAticle() method.
        $mes = ArticleRepository::queryArticle($title);
        return $mes;
    }
    /*
     * 推荐文章
     */
    public function featureArticle()
    {
        // TODO: Implement featureArticle() method.
        $mes = $this->art->featureArticle();
        return $mes;
    }
    /*
     * 最新文章
     */
    public function latestArticle()
    {
        // TODO: Implement featureArticle() method.
        $mes = $this->art->latestArticle();
        return $mes;
    }
    /*
     * 标签显示
     */
    public function showTag()
    {
        // TODO: Implement showTag() method.
        $data = $this->art->showTag();
        return $data;
    }
    /*
     * 分类显示
     */
    public function showCategory()
    {
        // TODO: Implement showCategory() method.
        $data = $this->art->showCategory();
        return $data;
    }
    /*
     * 显示某一类的所有文章
     */
    public function showOneCategory($category,$page){
        $data = $this->art->showOneCategory($category,$page);
        return $data;
    }
    /*
     * 按标签显示一类文章
     */
    public function showOneTag($tag,$page){
        $data = $this->art->showOneTag($tag,$page);
        return $data;
    }
    //显示一个文章的前30个字
    public function brief($id){
        $data = $this->art->brief($id);
        return $data;
    }
    //显示评论
    public function showComment($aid){
        $res = $this->art->showComment($aid);
        return $res;
    }
}