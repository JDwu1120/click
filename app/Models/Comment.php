<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //指定表名
    protected $table = 'comments';
    //指定可以批量赋值的字段
    protected $fillable = ['id','userName','aid','content','agree','power'];
}
