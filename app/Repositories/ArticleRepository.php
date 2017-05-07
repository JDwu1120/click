<?php
/**
 * Created by PhpStorm.
 * User: 111
 * Date: 2016/11/27
 * Time: 22:08
 */

namespace App\Repositories;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Img;
use App\Models\Collection;
use App\Models\UserInfo;
use Illuminate\Support\Facades\DB;

class ArticleRepository
{
    private $user;
    private $comment;
    private $art;
    /**
     * ArticleRepository constructor.
     * @param $user
     */
    public function __construct()
    {
        $this->user = new UserInfo();
        $this->comment = new Comment();
        $this->art = new Article();
    }

    /*
     * 发表文章
     */
    public static function addArticle($arr){
        if(empty($arr['power'])) $arr['power']='public';
        if(empty($arr['category'])) $arr['category']='science';
        if(empty($arr['tag'])) $arr['tag']='biology';
        $is = Article::where([
            'title'=>$arr['title'],
            'userName'=>$arr['userName'],
            'category'=>$arr['category'],
            'article' => $arr['article'],
            'tag' =>$arr['tag'],
            'power'=>$arr['power'],
        ])->get()->toArray();
        if (empty($is)) {
            $res = Article::create(
                ['title' => $arr['title'],
                'userName' => $arr['userName'],
                'category'=> $arr['category'],
                'article' => $arr['article'],
                'tag' => $arr['tag'],
                'power' => $arr['power'],
            ]);
            if ($res['incrementing']){
                return $res['attributes']['id'];
            }
        }else{
            return "请勿发表相同文章";
        }
    }
    /*
     * 储存文章附带的图片
     */
    public static function articleImg($arr){
        $res = Img::create([
            'userName' => $arr['userName'],
            'original' => $arr['original'],
            'size'     => $arr['size'],
            'type'     => $arr['type'],
            'url'      => $arr['url']
        ]);
        return $res;
    }
    /*
     * 显示所有文章
     */
    public static function showArticle($page){
        if ($page==0) $page=1;
        $count = Article::count();
        $pages = floor($count/10)+1;
        $curNum=($page-1)*10;
        $nexNum=($page)*10;
//        $res = DB::select('select * from click_articles order by updated_at desc limit '.$curNum.','.$nexNum);
        $res = DB::table('articles')->orderBy('updated_at','desc')->limit($curNum)->limit($nexNum)->get();
        $data=[
            'page'=> $page,
            'pages' => $pages,
            'data' => $res,
        ];
        return $data;
    }
    /*
     * 显示指定文章
     * 暂时不用
     */
//    public static function showOneArticle($id){
//        $res = Article::where([
//            'id' => $id
//        ])->get()->toArray()[0];
//        /*
//         * 文章右侧显示坐着的一些信息
//         */
//        $user = UserInfo::where([
//            'userName' => $res['userName'],
//        ])->get()->toArray()[0];
//        $time = $user['created_at'];
//        $arts = Article::where([
//            'userName' => $res['userName']
//        ])->count();
//        $good_arts = Article::where([
//            'userName' => $res['userName']
//        ])->orderBy('views','desc')->limit(10)->get()->toArray();
//        $retArt = [];
//        foreach ($good_arts as $good_art) {
//            $retArt[] = [
//                'id' => $good_art['id'],
//                'name' => $good_art['title'],
//                'category' => $good_art['category'],
//                'views' => $good_art['views']
//            ];
//        }
//        $time = explode(" ",$time)[0];
//        $res['age'] = $time;
//        $res['nums'] = $arts;
//        $res['good_art'] = $retArt;
//        return $res;
//    }
    /*
     * 删除指定文章
     */
    public static function delArticle($id){
        $res = Article::where([
            'id' => $id
        ])->delete();
        return $res;
    }
    /*
     * 修改指定文章
     */
    public static function editArticle($id,$content){
        $res = Article::where([
            'id' => $id
        ])->update([
            'title' => $content['title'],
            'Article' => $content['content'],
            'tag' => $content['tag'],
        ]);
        return $res;
    }
    /*
     * 查询文章
     */
    public static function queryArticle($title){
        $res = Article::where('title','like','%'.$title.'%')
            ->get()->toArray();
        return $res;
    }
    /*
     * 新增文章浏览量
     */
    public static function viewArticle($id){
        $num = Article::where([
            'id' => $id
        ])->increment('views',1);
        $res = Article::where([
            'id' => $id
        ])->get()->toArray()[0];
        /*
         * 文章右侧显示坐着的一些信息
         */
        $user = UserInfo::where([
            'userName' => $res['userName'],
        ])->get()->toArray()[0];
        $time = $user['created_at'];
        $arts = Article::where([
            'userName' => $res['userName']
        ])->count();
        $good_arts = Article::where([
            'userName' => $res['userName']
        ])->orderBy('views','desc')->limit(10)->get()->toArray();
        $retArt = [];
        foreach ($good_arts as $good_art) {
            $retArt[] = [
                'id' => $good_art['id'],
                'name' => $good_art['title'],
                'category' => $good_art['category'],
                'views' => $good_art['views']
            ];
        }
        $time = explode(" ",$time)[0];
        $res['user_id'] = $user['id'];
        $res['age'] = $time;
        $res['nums'] = $arts;
        $res['good_art'] = $retArt;
        return $res;
    }
    /*
     * 收藏文章
     */
    public static function colArticle($id,$userName){
        if (empty(Article::where('id',$id)->get()->toArray()))
        {
            exit();
        }
        //增加文章收藏数
        $res1 = Article::where([
            'id' => $id,
        ])->increment('collections',1);
        //记录收藏列表
        $res2 = Collection::create([
            'aid' => $id,
            'userName' => $userName
        ]);
        if ($res1&&$res2)
        {
            $res = true;
        }else{
            if ($res1){
                Collection::where([
                    'aid' => $id,
                    'userName' => $userName
                ])->delete();
            }else{
                Article::where([
                    'id' => $id,
                ])->decrement('collections',1);
            }
            $res = false;
        }
        return $res;
    }
    /*
     * 收藏列表
     */
    public static function collectionList($userName)
    {
        $res = Collection::where([
            'userName' => $userName
        ])->get()->toArray();
        return $res;
    }
    /*
     * 判断文章是否被收藏过
     */
    public static function isCollection($id,$userName)
    {
        $res = Collection::where([
            'aid' => $id,
            'userName' => $userName
        ])->get()->toArray();
        return $res;
    }
    /*
     * 删除文章
     */
    public static function delCollection($id,$userName)
    {
        $res1 = Article::where([
            'id' => $id,
        ])->decrement('collections',1);
        $res2 = Collection::where([
            'aid' => $id,
            'userName' => $userName
        ])->delete();
        if ($res1&&$res2){
            $res = true;
        }else{
            $res = false;
        }
        return $res;
    }
    /*
     * 留言评论
     */
    public function comment($aid,$userName,$content,$power,$token)
    {
        $username = $this->user->where([
            'token' => $token,
            'username' => $userName
        ])->get()->toArray()[0];
        if (empty($username)){
            return false;
        }
        $res = Comment::create([
            'aid' => $aid,
            'userName' => $userName,
            'content' => $content,
            'power'  =>  $power
        ]);
        $this->art->where([
            'id' => $aid
        ])->increment('comment_num',1);
        return true;
    }
    /*
     * 删除留言评论
     */
    public static function delComment($id,$aid,$userName)
    {
        //文章主人删除别人的留言
        $res1 = Article::where([
            'id' => $aid,
            'userName' => $userName
        ])->get()->toArray();
        if (!empty($res1)){
            $res = Comment::where([
                'id' => $id
            ])->delete();
        }else{
            $res = Comment::where([
                'id' => $id,
                'userName' => $userName,
            ])->delete();
        }
        return $res;
    }
    /*
     * 推荐文章
     */
    public function featureArticle(){
        $res = Article::orderBy('views','desc')->orderBy('updated_at','desc')->limit(10)->get()->toArray();
        $res1=[];
        foreach ($res as $value) {
            $a =  explode(" ",date(DATE_RFC1123,strtotime($value['created_at'])));
            $b = $a[1]." ".$a[2].', '.$a[3];
            $res1[] = [
                'id' => $value['id'],
                'title' => $value['title'],
                'userName'=> $value['userName'],
                'views' => $value['views'],
                'time'  => $b,
                'collections'=>$value['collections'],
                'category' => $value['category']
            ];
        }
        return $res1;
    }
    /*
     * 最新文章
     */
    public function latestArticle(){
        $res = Article::orderBy('created_at','desc')->limit(30)->get()->toArray();
        $res1=[];
        foreach ($res as $value){
            $a =  explode(" ",date(DATE_RFC1123,strtotime($value['created_at'])));
            $b = $a[1]." ".$a[2].', '.$a[3];
            $res1[] = [
                'id' => $value['id'],
                'title' => $value['title'],
                'userName'=> $value['userName'],
                'views' => $value['views'],
                'time'  => $b,
                'collections'=>$value['collections'],
                'category' => $value['category']
            ];
        }
        return $res1;
    }
    /*
     * 显示标签
     */
    public function showTag(){
        $tag=Article::select('tag')->get()->toArray();
        $res = [];
        foreach ($tag as $value){
            $res[] = explode(';',$value['tag']);
        }
        $msg = [];
        $len = $i=count($res);
        for($i=0;$i<$len;$i++){
            foreach ($res[$i] as $k){
                $msg[] = $k;
            }
        }
        $msg = array_flip(array_flip($msg));
        shuffle($msg);
        if (count($msg)>10){
            $res1 = array_slice($msg,0,10);
            return $res1;
        }
        return $msg;
    }
    /*
     * 分类标签
     */
    public function showCategory(){
        $res = [];
        $category = DB::select("SELECT count(*) as num,category FROM click_articles GROUP BY category DESC limit 10");
        foreach ($category as $k){
            $res[] = [
                'num' => $k->num,
                'name' => $k->category
            ];
        }
        return $res;
    }
    /*
     * 按分类显示一类文章
     */
    public function showOneCategory($category,$page){
        if ($page==0) $page=1;
        $count = Article::where(['category'=>$category])->count();
        $pages = floor($count/10)+1;
        $curNum=($page-1)*10;
        $nexNum=($page)*10;
//        $res = DB::select('select * from click_articles where category = ? order by updated_at desc limit '.$curNum.','.$nexNum,[$category]);
        $res = DB::table('articles')->where('category',$category)->limit($curNum)->limit($nexNum)->get();
        $data = [
            'pages'=>$pages,
            'msg' => $res
        ];
        return $data;
    }
    /*
     * 按某一种标签显示文章
     */
    public function showOneTag($tag,$page){
        $tag1 = Article::where('tag','like','%'.$tag.'%')->get()->toArray();
        if ($page==0) $page=1;
        $count = count($tag1);
        $pages = floor($count/10)+1;
        $curNum=($page-1)*10;
        $nexNum=($page)*10;
//        $res1 = DB::select("select * from click_articles where tag like '%".htmlspecialchars($tag)."%' order by updated_at desc limit ".$curNum.",".$nexNum);
        $res1 = DB::table('articles')->where('tag','like','%'.$tag.'%')->limit($curNum)->limit($nexNum)->get();
        $data = [
            'pages'=>$pages,
            'msg' => $res1
        ];
        return $data;
    }
    //显示文章简介
    public function brief($id){
        $res = Article::where([
            'id' => $id
        ])->get()->toArray();
        if (empty($res)){
            return false;
        }else{
            foreach ($res as $k){
                $brief = substr($k['article'],0,30);
            }
        }
        return $brief;
    }
    //显示评论
    public function showComment($id){
        $res = $this->comment->where([
            'aid' => $id
        ])->get()->toArray();
        $arr = [];
        if (empty($res)){
            return false;
        }else{
            foreach ($res as $k){
                $arr[] = [
                    'id' => $k['id'],
                    'userName' => $k['userName'],
                    'content' => $k['content'],
                    'date' => $k['updated_at'],
                    'agree' => $k['agree']
                ];
            }
            return $arr;
        }
    }
}