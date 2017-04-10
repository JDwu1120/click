<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //指定表面
    protected $table = "news";
    //指定主键
    protected $primaryKey = 'id';
    //指定可以批量赋值的字段
    protected $fillable = ['id','title','message','admin','created_at','updated_at'];
}
