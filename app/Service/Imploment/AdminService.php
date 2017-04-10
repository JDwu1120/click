<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2017/3/26
 * Time: 下午8:18
 */

namespace App\Service\Imploment;


use App\Repositories\AdminRepository;
use App\Service\AdminInterface;

class AdminService implements AdminInterface
{
    public $admin;
    /**
     * AdminService constructor.
     */
    public function __construct()
    {
        $this->admin = new AdminRepository();
    }
    //显示主页更新信息
    public static function showNews()
    {
        // TODO: Implement showNews() method.
        $news = AdminRepository::getNews();
        return $news;
    }
}