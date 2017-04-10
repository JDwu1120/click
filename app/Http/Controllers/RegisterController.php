<?php

namespace App\Http\Controllers;

use App\Service\Imploment\mailService;
use App\Service\Imploment\userRegisterService;
use App\Service\Imploment\VerifyService;
use Illuminate\Http\Request;
use App\dto\Operate;
class RegisterController extends Controller
{
    private $reg;

    /**
     * RegisterController constructor.
     * @param $reg
     */
    public function __construct()
    {
        $this->reg = new userRegisterService();
    }
    public function userRegister(Request $request){
        $username = $request->input('userName');
        $nickname = $request->input('nickName');
        $passwd = md5($request->input('passwd'));
        $verifyInput = $request->input('verify');
        $email = $request->input('email');
        if ($this->reg->checkUserName($username)){
            if ($this->reg->checkNickName($nickname)){
                $ve = new VerifyService($verifyInput,$email);
                $msg = null;
                if ($ve->checkVerify()){
                    $msg = $this->reg->userRegister($username,$passwd,$nickname,$email);
                    return json_encode($msg);
                }else{
                    return json_encode(new Operate(false,'验证码已经失效',0,false));
                }
            }else{
                return json_encode(new Operate(false,'昵称重复',0,null));
            }
        }else{
                return json_encode(new Operate(false,'用户名重复',0,null));
        }
    }
}
