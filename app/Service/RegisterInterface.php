<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2017/4/5
 * Time: 下午3:57
 */

namespace App\Service;


interface RegisterInterface
{
    //注册
    public function userRegister($username,$passwd,$nickname,$email);
    //检查是否重名
    public function checkUserName($username);
    //检查昵称是否重复
    public function checkNickName($nickname);
}