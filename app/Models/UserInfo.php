<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    //指定主键
    protected $primaryKey ='id';
    //指定表名
    protected $table = 'userinfo';
    //指定可以批量赋值的字段
    protected $fillable = ['id','uid','userName','nickName','passwd','email','token','phone','ctime','status'];
}
