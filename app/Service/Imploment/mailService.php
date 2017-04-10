<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2017/4/5
 * Time: 下午10:30
 */

namespace App\Service\Imploment;

use App\Repositories\localUserRepository;
use Rainwsy\Aliyunmail\Send\Single;
use Rainwsy\Aliyunmail\Auth;
class mailService
{
    private $email;
    private $verify;
    /**
     * mailService constructor.
     */
    public function __construct($email,$verify)
    {
        $this->email = $email;
        $this->verify = $verify;
    }

    public function send()
    {
        $AccessKeyId = 'LTAI7WdJEmRKpSBu';
        $AccessSecret = '0ni5USXyMXmAEu43X2H5OgUDXqrIEm';
        $auth = Auth::config($AccessKeyId, $AccessSecret);
        $mail = new Single();
        $mail->setAccountName('messenger@dm.clickgwas.org');
        $mail->setFromAlias('wujindong');
        $mail->setReplyToAddress('true');
        $mail->setAddressType('1');
        $mail->setToAddress($this->email);
        $mail->setSubject('欢迎您使用我们的论坛，请输入以下验证码完成注册');
        $mail->setHtmlBody('您的验证码为'.$this->verify);
        $send = $mail->send();
        $send = json_decode($send,true);
        if (count($send)<3){
            return true;
        }else{
            return false;
        }
    }
    public function chechEmail($email){
        $mail = new localUserRepository();
        if ($mail->checkEmail($email)){
            return true;
        }else{
            return false;
        }
    }
}
