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
        $mail->setFromAlias('Clickgwas');
        $mail->setReplyToAddress('true');
        $mail->setAddressType('1');
        $mail->setToAddress($this->email);
        $mail->setSubject('Welcome to the Click community');
//        $mail->setHtmlBody('Your CAPTCHA is'.$this->verify);
        $mail->setHtmlBody("<html><head><title>click</title><meta charset='utf-8'></head><body><style>body{font-family:Microsoft Yahei;}#main{width:500px;height:300px;margin:0 auto;border-collapse:separate;border-spacing:2px;box-shadow:0px 0px 0px 0px#C9C9C9;overflow:hidden}.head{width:500px;height:50px;background:url('http://smilewithu.com/click/headerbgn2.jpg')no-repeat}img{height:50px;width:69px;margin:2px}.container{width:500px;height:250px}.container-text{font-size:40px;text-align:center;color:#715694;font-weight:bold;height:70px;line-height:90px}.container span{text-align:center;font-size:17px;display:block;height:50px}.container.container-activation{text-align:center;height:80px;overflow:hidden}.container.container-activation a{background:#fff;text-decoration:none;border:solid 1px#653885;border-radius:4px;color:#715694;display:block;width:120px;height:50px;line-height:50px;margin:15px auto}.container.annotation{font-size:12px;color:#C4C4C4;height:50px;display:block;padding-top:10px}</style><div id='main'><div class='container'><div class='container-text'>welcome to click！</div><span>Thanks for joining us.<br>Your CAPTCHA is<i style='color:#00a1e9'>".$this->verify."</i></span><div class='container-activation'></div><span class='annotation'>This verify is valid for 10 minutes.<br>Please ignore this email if you did not take relative operation.</span></div></div></body></html>");
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
