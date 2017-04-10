<?php

/**
 * Created by PhpStorm.
 * User: 111
 * Date: 2016/11/27
 * Time: 17:14
 */
namespace App\Service;
interface UserInterface
{
  /*
   * 浏览文章接口
   */
  public function viewArticle($id);
  /*
   * 收藏文章接口
   */
  public function colArticle($id,$userName);
  /*
   * 收藏列表
   */
  public function collectionList($userName);
  /*
   * 判断文章是否呗收藏过
   */
  public function isCollection($id,$userName);
  /*
   * 取消收藏
   */
  public function delCollection($id,$userName);
  /*
   * 评论留言
   */
  public function comment($aid,$userName,$content,$power);
  /*
   * 删除留言评论
   */
  public function delComment($id,$aid,$userName);
  /*
   * 存入用户发表的文章
   */
    public function addArticle($text);
}