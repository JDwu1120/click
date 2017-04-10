<?php

/**
 * Created by PhpStorm.
 * User: 111
 * Date: 2016/11/27
 * Time: 17:07
 */
namespace App\Repositories;
use App\Models\UserInfo;
class UserRepository
{

    /**
     * UserRepository constructor.
     */
    private $userInfo;
    public function __construct()
    {
        $this->userInfo = new UserInfo();
    }
    public function saveUserInfo($data){
        $res = $this->userInfo->create([
            'uid' => $data['id'],
            'userName' => $data['username'],
            'email' => $data['email'],
            'token' => $data['token'],
            'phone' => $data['phone'],
            'ctime' => $data['ctime']
        ]);
        if ($res['incrementing']){
            return true;
        }
    }
    //更新用户token
    public function updateToken($uid,$token){
        $res = $this->userInfo->where([
            'uid'=>$uid
        ])->update([
            'token'=>$token
        ]);
        if ($res){
            return true;
        }
    }
    //查找用户是否存在
    public function findUser($uid){
        $res = $this->userInfo->where([
            'uid'=>$uid
        ])->get()->toArray();
        if (empty($res)){
            return false;
        }else{
            return true;
        }
    }
    //检查token
    public function checkToken($token){
        $res = $this->userInfo->where([
            'token'=>$token,
        ])->get()->toArray();
        if (!empty($res)&&$res[0]['token']!=0){
            return $res;
        }else{
            return false;
        }
    }
    //从论坛表中获取用户信息
    public function getInfo($token){
        $res = $this->userInfo->where([
            'token' => $token,
        ])->get()->toArray();
        if (!empty($res)){
            $msg = [
                'userName' =>  $res[0]['userName'],
                'email' =>  $res[0]['email'],
                'token' => $token,
            ];
            return $msg;
        }else{
            return false;
        }
    }
    //local用户登录
    public function localLogin($username,$passwd){
        $res = $this->userInfo->where([
            'userName' => $username,
            'passwd' => $passwd
        ])->get()->toArray();
        if (empty($res)){
            return false;
        }else{
            //更新token;
            $token = md5($username.$passwd.time());
            $this->userInfo->where([
                'userName' => $username,
            ])->update([
                'token' => $token,
            ]);
            $msg = [
                'userName' => $res[0]['userName'],
                'token' => $token
            ];
            return $msg;
        }
    }
    //用户注销
    public function localLogout($username,$token){
        $res = $this->userInfo->where([
            'userName' => $username,
            'token' => $token
        ])->update([
            'token' => 0
        ]);
        if ($res){
            return true;
        }else{
            return false;
        }
    }
}