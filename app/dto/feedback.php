<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2017/4/23
 * Time: 下午10:36
 */

namespace App\dto;


class feedback
{
    private $status;
    private $data;

    /**
     * feedback constructor.
     * @param $status
     * @param $data
     */
    public function __construct($status, $data)
    {
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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

}