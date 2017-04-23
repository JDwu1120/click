<?php

namespace App\dto;
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2016/12/20
 * Time: 下午9:23
 */
class Operate
{
    public $state;
    public $message;
    public $data;
    public $isLogin;
    /**
     * Operate constructor.
     * @param $state
     * @param $message
     * @param $data
     */
    public function __construct($state,$message,$isLogin,$data)
    {
        $this->state = $state;
        $this->message = $message;
        $this->data = $data;
        $this->isLogin =$isLogin;
    }


    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getIsLogin()
    {
        return $this->isLogin;
    }

    /**
     * @param mixed $isLogin
     */
    public function setIsLogin($isLogin)
    {
        $this->isLogin = $isLogin;
    }

}