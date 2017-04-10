<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2017/3/26
 * Time: 下午1:49
 */

namespace App\Service\Imploment;
use App\dto\Operate;
use App\Repositories\UserRepository;
use App\Service\LoginInterface;

class LoginService implements LoginInterface
{

    /*
   * 检查用户是否登陆
   */
    /**
     * LoginService constructor.
     */
    public $user;
    public $token;
    public function __construct()
    {
        $this->user = new UserRepository();
    }

    public function checkLog($token)
    {
        // TODO: Implement checkLog() method.
        $info=$this->user->checkToken($token);

        if ($info){
            return 1;
        }else{
            return 0;
        }
    }
    /*
     * 请求单点登录
     */
    public function getToken()
    {
        // TODO: Implement getLog() method.
        $appkey = 'testappkey';
        $appsecretkey = 'testappsecretkey';
        $timestamp = time();
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for ( $i = 0; $i < 32; $i++ )
        {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        $hash = $password;
        $url = 'http://47.88.77.83:8080/sso/thrid/'.$appkey.'/'.$appsecretkey.'/'.$timestamp.'/'.$hash.'/access';
        $headers = array();
        $headers[] = 'X-Apple-Tz: 0';
        $headers[] = 'X-Apple-Store-Front: 143444,12';
        $headers[] = 'Host:47.88.77.83';
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $headers[] = 'Accept-Encoding: gzip, deflate';
        $headers[] = 'Accept-Language: en-US,en;q=0.5';
        $headers[] = 'Cache-Control: no-cache';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
        $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_2) AppleWebKit/602.3.12 (KHTML, like Gecko) Version/10.0.2 Safari/602.3.12';
        $headers[] = 'X-MicrosoftAjax: Delta=true';
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        return $output;
    }
    public function getLogin(){
        $res = $this->getToken();
        $token = json_decode($res,true)['data']['token']['token'];
        $url = 'http://47.88.77.83:8080/sso/thrid/'.$token.'/getLogin';
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        return $output;
    }
    /*
     * 获取用户信息
     */
    public function getUserInfo($token,$utoken)
    {
        $url = 'http://47.88.77.83:8080/sso/thrid/'.$token.'/'.$utoken.'/getuserinfo';
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        $res = json_decode($output,true);
        $info = $res['data'];
        if ($res['state']){
            if ($this->user->findUser($info['id'])){
               $msg = $this->user->updateToken($info['id'],$info['token']);
               $data['token'] = $info['token'];
                return new Operate($msg,"",1,$info);
            }else{
                $msg = $this->user->saveUserInfo($info);
                $data['token'] = $info['token'];
                return new Operate($msg,"",1,$info);
            }
        }
        return new Operate($res['state'],$res['msg'],0,$res['data']);
    }
    /*
     * 本地用户登录
     */
    public function localLogin($username, $passwd)
    {
        // TODO: Implement localLogin() method.
        $res = $this->user->localLogin($username,$passwd);
        if ($res){
            return new Operate(true,'success',1,$res);
        }else{
            return new Operate(false,'failed',0,$res);
        }
    }
    /*
     *  本地用户注销
     */
    public function localLogout($username,$token){
        $res = $this->user->localLogout($username,$token);
        if ($res){
            return new Operate(true,'success',0,$res);
        }else{
            return new Operate(false,'failed',1,$res);
        }
    }
}