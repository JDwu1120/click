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
class ArticleRepository
{
    /*
     * 储存文章
     */
    public static function addArticle($arr)
    {
        if(empty($arr['power'])) $arr['power']='public';
        $is = Article::where([
                'title'=>$arr['title'],
                'userName'=>$arr['userName'],
                'category'=>$arr['category'],
                'article' => $arr['article'],
                'tag1' =>$arr['tag1'],
                'tag2' =>$arr['tag2'],
                'tag3' =>$arr['tag3'],
                'tag4' =>$arr['tag4'],
                'tag5' =>$arr['tag5'],
                'power'=>$arr['power'],
        ])->get()->toArray();
        if (empty($is)) {
            $res = Article::create(['title' => $arr['title'],
                'userName' => $arr['userName'],
                'category'=>$arr['category'],
                'article' => $arr['article'],
                'tag1' => $arr['tag1'],
                'tag2' => $arr['tag2'],
                'tag3' => $arr['tag3'],
                'tag4' => $arr['tag4'],
                'tag5' => $arr['tag5'],
                'power' => $arr['power'],
            ]);
        }else{
            $res = '请勿发表相同文章';
        }
        return $res;
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
    public static function showArticle(){
        $res = Article::all()->toArray();
        return $res;
    }
    /*
     * 显示指定文章
     */
    public static function showOneArticle($id){
        $res = Article::where([
            'id' => $id
        ])->get()->toArray();
        return $res;
    }
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
            'tag1' => $content['tag1'],
            'tag2' => $content['tag2'],
            'tag3' => $content['tag3'],
            'tag4' => $content['tag4'],
            'tag5' => $content['tag5'],
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
        $res = Article::where([
            'id' => $id
        ])->increment('views',1);
        return $res;
    }
    /*
     * 收藏文章
     */
    public static function colArticle($id,$userName){
        if (Article::where('id',$id)->get()->toArray()==null)
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
     * 判断文章是否呗收藏过
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
    public static function comment($aid,$userName,$content,$power)
    {
        if (empty($power)) $power='public';
        $res = Comment::create([
            'aid' => $aid,
            'userName' => $userName,
            'content' => $content,
            'power'  =>  $power
        ]);
        return $res;
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
        $res = Article::orderBy('views','desc')->limit(10)->get()->toArray();
        foreach ($res as $value) {
            $a =  explode(" ",date(DATE_RFC1123,strtotime($value['created_at'])));
            $b = $a[1]." ".$a[2].', '.$a[3];
            $res1[] = [
                'title' => $value['title'],
                'time'  => $b,
                'category' => $value['category']
            ];
        }
        return $res1;
    }
    /*
     * 最新文章
     */
    public function latestArticle(){
        $res = Article::orderBy('created_at','desc')->limit(10)->get()->toArray();
        $res = Article::select('tag1')->get()->toArray();
        return $res;
    }
    /*
     * 显示标签
     */
    public function showTag(){
        $tag1 = Article::select('tag1')->get()->toArray();
        $tag2 = Article::select('tag2')->get()->toArray();
        $tag3 = Article::select('tag3')->get()->toArray();
        $tag4 = Article::select('tag4')->get()->toArray();
        $tag5 = Article::select('tag5')->get()->toArray();
        $data = array_merge($tag1,$tag2,array_merge($tag3,array_merge($tag4,$tag5)));
        foreach ($data as $key => $value){
            foreach ($value as $item) {
                $tag[] = $item;
            }
        }
        $tag = array_flip(array_flip($tag));
        foreach ($tag as $value){
            $res[] = $value;
        }
        shuffle($res);
        if (count($res)>16){
            $res1 = array_slice($res,0,16);
            return $res1;
        }
        return $res;
    }
    /*
     * 分类标签
     */
    public function showCategory(){
        $category = Article::select('category')->get()->toArray();
        $data = [];
        foreach ($category as $value) {
            if (!array_key_exists($value['category'],$data)){
                $data[$value['category']] = 1;
            }
            $data[$value['category']]++;
        }
        $cp = $data;
        rsort($data);
        if (count($data)>=6) {
            $res1 = array_slice($data, 0, 6);
            $i = 0;
            foreach ($cp as $k => $v) {
                if (in_array($v, $res1)) {
                    if ($v == $res1[5] && $i != 0) {
                        continue;
                    }
                    if ($v == $res1[5]) $i++;
                    $res[] = $k;
                }
            }
        }else{
            foreach ($cp as $k => $v) {
                $res[] = $k;
            }
        }
        return $res;
    }
}