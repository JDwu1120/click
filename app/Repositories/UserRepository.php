<?php

/**
 * Created by PhpStorm.
 * User: 111
 * Date: 2016/11/27
 * Time: 17:07
 */
namespace App\Repositories;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\UserInfo;
class UserRepository
{

    /**
     * UserRepository constructor.
     */
    private $userInfo;
    private $com;
    private $rep;
    private $art;
    public function __construct()
    {
        $this->userInfo = new UserInfo();
        $this->com = new Comment();
        $this->rep = new Reply();
        $this->art = new Article();
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
    //用户点赞
    public function agreeComs($id){
        $res = $this->com->where([
            'id' => $id
        ])->increment('agree',1);
        return $res;
    }
    //评论回复
    public function reply($aid,$cid,$content,$userName){
        $res = $this->rep->create([
            'aid' => $aid,
            'cid' => $cid,
            'content' => $content,
            'userName' => $userName
        ]);
        if ($res['incrementing']){
            return true;
        }else{
            return false;
        }
    }
    //显示用户信息
    public function showUserMsg($userName){
        $users = $this->userInfo->where([
            'userName' => $userName,
        ])->get()->toArray()[0];
        $com = $this->com->where([
            'userName' => $userName
        ])->count();
        $rep = $this->rep->where([
            'userName' => $userName
        ])->count();
        $arg = $this->art->where([
            'userName' => $userName
        ])->get()->toArray();
        $retArt = [];
        foreach ($arg as $good_art) {
            $com_num = $this->com->where([
                'aid' => $good_art['id'],
            ])->count();
            $retArt[] = [
                'id' => $good_art['id'],
                'name' => $good_art['title'],
                'category' => $good_art['category'],
                'views' => $good_art['views'],
                'created_at'=> $good_art['created_at'],
                'art_com' => $com_num
            ];
        }
        $user = [
              "userName" => $users['userName'],
              "nickName" => $users['nickName'],
              "email" => $users['email'],
              "phone" => $users['phone'],
              "created_at" => $users['created_at']
        ];
        $user['com_num'] = $com;
        $user['rep_num'] = $rep;
        $user['art'] = $retArt;
        return $user;
    }
}