<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2017/4/5
 * Time: 下午11:10
 */

namespace App\Service\Imploment;


use App\dto\Operate;
use App\Repositories\VerifyRepository;

class VerifyService
{
    private $verify;
    private $email;

    /**
     * VerifyService constructor.
     * @param $verify
     * @param $email
     */
    public function __construct($verify, $email)
    {
        $this->verify = $verify;
        $this->email = $email;
    }

    public function saveVerify(){
        $ve = new VerifyRepository($this->verify,$this->email);
        $res = $ve->saveVerify();
        if ($res){
            return true;
        }else{
            return new Operate(false,'验证码储存失败',0,$res);
        }
    }

    //检查验证码是否过期
    public function checkVerify(){
        $ve = new VerifyRepository($this->verify,$this->email);
        $res = $ve->checkVerify();
        if ($res){
            return true;
        }else{
            return false;
        }
    }
}