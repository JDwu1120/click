<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2017/3/26
 * Time: 下午1:29
 */

namespace App\Service;


interface LoginInterface
{
    /*
    * 单点检验用户登陆的接口
    */
    public function checkLog($token);
    /*
     * 请求单点登陆
     */
    public function getToken();
    /*
     * 单点获取用户信息
     */
    public function getUserInfo($token,$utoken);
    /*
     * local用户登录
     */
    public function localLogin($username,$passwd);
}