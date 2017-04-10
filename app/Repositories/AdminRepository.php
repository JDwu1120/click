<?php
/**
 * Created by IntelliJ IDEA.
 * User: wujindong
 * Date: 2017/3/26
 * Time: 下午8:19
 */

namespace App\Repositories;


use App\Models\News;

class AdminRepository
{
    public $news;
    /**
     * AdminRepository constructor.
     */
    public function __construct()
    {
        $this->news = new News();
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
                'title'=>$value['title']
            ];
        }
        return $res;
    }
}