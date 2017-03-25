<?php
/**
 * Created by PhpStorm.
 * User: 111
 * Date: 2016/11/27
 * Time: 22:15
 */

namespace App\Http\Controllers;
use App\Repositories\ArticleRepository;
use App\Service\Imploment\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /*
     * 添加文章
     */
    public function addArticle(Request $request)
    {
        $ArticleInfo = [
            'title' => $request->input('title'),
            'article' => $request->input('article'),
            'userName' => $request->input('userName'),
            'tag1' => $request->input('tag1'),
            'tag2' => $request->input('tag2'),
            'tag3' => $request->input('tag3'),
            'tag4' => $request->input('tag4'),
            'tag5' => $request->input('tag5'),
            'power' => $request->input('power'),
        ];
        $data = ArticleService::addArticle($ArticleInfo);
        return json_encode($data);
    }
    /*
     * 添加图片
     */
    public function articleImg(Request $request)
    {
        $arr = [
            "userName" => $request->input('userName'),
            "original" => $request->input('original'),
            "size"     => $request->input('size'),
            "type"     => $request->input('type'),
            "url"      => $request->input('url')
        ];
        $data = ArticleService::articleImg($arr);
        return json_encode($data);
    }
    /*
     * 显示所有文章
     */
    public function showArticle(){
        $data = ArticleService::showArticle();
        echo json_encode($data);
    }
    /*
     * 显示某个文章
     */
    public function showOneArticle(Request $request){
        $data = ArticleService::showOneArticle($request->input('id'));
        return json_encode($data);
    }
    /*
     * 删除文章
     */
    public function delArticle(Request $request){
        $data = ArticleService::delArticle($request->input('id'));
        return json_encode($data);
    }
    /*
     * 修改指定文章
     */
    public function editArticle(Request $request){
        $id = $request->input('id');
        $ArticleInfo = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'category' => $request->input('category'),
            'tag1' => $request->input('tag1'),
            'tag2' => $request->input('tag2'),
            'tag3' => $request->input('tag3'),
            'tag4' => $request->input('tag4'),
            'tag5' => $request->input('tag5'),
        ];
        $data = ArticleService::editAticle($id,$ArticleInfo);
        return json_encode($data);
    }
    /*
     * 查询文章
     */
    public function queryArticle(Request $request){
        $title = $request->input('title');
        $data = ArticleService::queryAticle($title);
        return json_encode($data);
    }
    /*
     * 推荐文章
     */
    public function featureArticle(){
        $art = new ArticleService();
        $data = $art->featureArticle();
        return json_encode($data);
    }
    /*
     * 最新文章
     */
    public function latestArticle(){
        $art = new ArticleService();
        $data = $art->latestArticle();
        return json_encode($data);
    }
    /*
     * 标签显示
     */
    public function showTag(){
        $art = new ArticleService();
        $data = $art->showTag();
        return json_encode($data);
    }
    /*
     * 分类显示
     */
    public function showCategory(){
        $art = new ArticleService();
        $data = $art->showCategory();
        return json_encode($data);
    }
}