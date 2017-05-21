<?php

namespace App\Http\Controllers;

use App\Service\Imploment\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public $user;
    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->user=new LoginService();
    }
    //获取登录界面
    public function getLogin(){
        $info = $this->user->getLogin();
        echo $info;
    }
    //获取token
    public function getToken(Request $request){
        $token = $request->input('ticket');
        $utoken = $request->input('utoken');
        $info = $this->user->getUserInfo($token,$utoken);
        setcookie("token",$info->data['token']);
        setcookie("username",$info->data['username']);
        return redirect("http://forum.clickgwas.org");
    }
    //local Login
    public function localLogin(Request $request){
        $username = $request->input('userName');
        $passwd = md5($request->input('passwd'));
        $res = $this->user->localLogin($username,$passwd);
        return json_encode($res);
    }
    //local logout
    public function localLogout(Request $request){
        $username = $request->input('userName');
        $token = $request->input('token');
        $res = $this->user->localLogout($username,$token);
        return json_encode($res);
    }
}
