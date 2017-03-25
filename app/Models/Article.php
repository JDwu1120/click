<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //指定表名
    protected $table = 'articles';
    //指定可以批量赋值的字段
    protected $fillable = ['title','userName','article','tag1','tag2','tag3','tag4','tag5','power'];
}
