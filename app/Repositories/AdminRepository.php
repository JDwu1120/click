<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2017/3/26
 * Time: 下午8:19
 */

namespace App\Repositories;


use App\Models\News;
use App\Models\UserInfo;
use League\Flysystem\Exception;

class AdminRepository
{
    public $news;
    public $user;
    /**
     * AdminRepository constructor.
     */
    public function __construct()
    {
        $this->news = new News();
        $this->user = new UserInfo();
    }
    /*
     * 获取主页的更新信息
     */
    public static function getNews(){
        $news = News::orderBy('updated_at','desc')->limit(7)->get()->toArray();
        $res=[];
        foreach ($news as $value){
            $res[]=[
                'id'=>$value['id'],
                'title'=>$value['title'],
                'date'=>$value['updated_at'],
            ];
        }
        return $res;
    }
    //检查用户是否为管理员
    public function adminCheck($email){
        try{
            $user = $this->user->where([
                'email' => $email
            ])->get()->toArray()[0];
        }catch (Exception $e){
            return $e->getMessage();
        }
        if ($user['status'] == 1){
            return true;
        }else{
            return false;
        }
    }
    //添加更新信息
    public function addNews($arr){
        $this->news->create($arr);
        return true;
    }
}