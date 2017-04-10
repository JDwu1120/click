<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2017/4/5
 * Time: 下午3:58
 */

namespace App\Service\Imploment;

use App\dto\Operate;
use App\Repositories\localUserRepository;
use App\Service\RegisterInterface;
class userRegisterService implements RegisterInterface
{
    private $user;

    /**
     * userRegisterService constructor.
     * @param $user
     */
    public function __construct()
    {
        $this->user = new localUserRepository();
    }

    public function userRegister($username, $passwd, $nickname, $email)
    {
        // TODO: Implement userRegister() method.
        $res = $this->user->userRegister($username,$passwd,$nickname,$email);
        if ($res){
            return new Operate($res,'注册成功',0,null);
        }else{
            return new Operate($res,'注册失败',0,null);
        }
    }

    public function checkUserName($username)
    {
        // TODO: Implement checkUserName() method.
        $res = $this->user->checkUserName($username);
        return $res;
    }
    public function checkNickName($nickname)
    {
        // TODO: Implement checkNickName() method.
        $res = $this->user->checkNickName($nickname);
        return $res;
    }
}