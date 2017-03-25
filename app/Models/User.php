<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //指定表名
    protected $table = 'users';
    //指定可以批量赋值的字段
    protected $fillable = ['username'];
}
