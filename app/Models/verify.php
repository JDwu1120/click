<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class verify extends Model
{
    //指定主键
    protected $primaryKey ='id';
    //指定表名
    protected $table = 'verify';
    //指定可以批量赋值的字段
    protected $fillable = ['id','email','time','verify'];
}
