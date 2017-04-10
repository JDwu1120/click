<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2017/4/5
 * Time: 下午11:11
 */

namespace App\Repositories;


use App\Models\verify;

class VerifyRepository
{
    private $verify;
    private $verifyModel;
    private $email;
    /**
     * VerifyRepository constructor.
     */
    public function __construct($verify,$email)
    {
        $this->verify = $verify;
        $this->email = $email;
        $this->verifyModel = new verify();
    }
    public function saveVerify(){
//        $is = $this->verifyModel->where([
//            'email' => $this->email,
//        ])->get()->toArray();
        $re = $this->verifyModel->create([
            'email' => $this->email,
            'verify' => $this->verify,
            'time' => time()+60*10
        ]);
        if ($re['incrementing']){
            return true;
        }else{
            return false;
        }
    }
    //检查验证码是否过期
    public function checkVerify(){
        $res = $this->verifyModel->where([
            'email' => $this->email,
            'verify' => $this->verify
        ])->where('time','>',time())->get()->toArray();
        if (!empty($res)){
            return true;
        }else{
            return false;
        }
    }
}