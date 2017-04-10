<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2017/4/5
 * Time: 下午4:10
 */

namespace App\Repositories;


use App\Models\UserInfo;
use App\Models\Users;

class localUserRepository
{
    private $user;

    /**
     * localUserRepository constructor.
     * @param $user
     */
    public function __construct()
    {
        $this->user = new UserInfo();
    }
    //注册
    public function userRegister($userName,$passwd,$nickName,$email){
        $cre = $this->user->create([
            'userName' => $userName,
            'passwd' => $passwd,
            'email' => $email,
            'nickName' => $nickName,
            'token' => md5($userName.$nickName.time()),
        ]);
        if ($cre['incrementing']){
            return true;
        }else{
            return false;
        }
    }
    // 检查是否重用户名
    public function checkUserName($username){
        $res = $this->user->where([
            'userName' => $username,
        ])->get()->toArray();
        if (empty($res)){
            return true;
        }else{
            return false;
        }
    }
    //检查是否昵称重复
    public function checkNickName($nickname){
        $res = $this->user->where([
            'nickName' => $nickname,
        ])->get()->toArray();
        if (empty($res)){
            return true;
        }else{
            return false;
        }
    }
    //检查邮箱是否重复
    public function checkEmail($email){
        $res = $this->user->where([
            'email' => $email
        ])->get()->toArray();
        if(empty($res)){
            return true;
        }else{
            return false;
        }
    }

}