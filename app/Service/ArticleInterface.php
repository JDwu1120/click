<?php
/**
 * Created by PhpStorm.
 * User: 111
 * Date: 2016/11/27
 * Time: 22:11
 */

namespace App\Service;


interface ArticleInterface
{
   /*
    * 保存用户传入的图片
    */
   public function articleImg($arr);
   /*
    * 显示所有的文章
    */
   public function showArticle($page);
   /*
    * 显示指定文章
    */
   public function showOneArticle($id);
   /*
    * 删除指定文章
    */
   public function delArticle($id);
   /*
    * 修改指定文章
    */
   public function editAticle($id,$content);
   /*
    * 查询文章
    */
   public function queryArticle($title);
   /*
    * 推荐文章
    */
   public function featureArticle();
   /*
    * 最新文章
    */
   public function latestArticle();
   /*
    * 标签显示
    */
   public function showTag();
   /*
    * 显示分类
    */
   public function showCategory();
   /*
    * 显示某一类文章
    */
   public function showOneCategory($category,$page);
}