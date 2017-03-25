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
   * 检验用户登陆的接口
   */
  public static function checkLog();
  /*
   * 请求单点登陆
   */
  public static function getToken();
  /*
   * 获取用户信息
   */
  public static function getUserInfo();
  /*
   * 浏览文章接口
   */
  public static function viewArticle($id);
  /*
   * 收藏文章接口
   */
  public static function colArticle($id,$userName);
  /*
   * 收藏列表
   */
  public static function collectionList($userName);
  /*
   * 判断文章是否呗收藏过
   */
  public static function isCollection($id,$userName);
  /*
   * 取消收藏
   */
  public static function delCollection($id,$userName);
  /*
   * 评论留言
   */
  public static function comment($aid,$userName,$content,$power);
  /*
   * 删除留言评论
   */
  public static function delComment($id,$aid,$userName);
}