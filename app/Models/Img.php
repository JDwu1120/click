<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
    //指定表名
    protected $table = 'imgs';
    //指定主键
    protected $primaryKey ='id';
    //指定可以批量赋值的字段
    protected $fillable = ['userName','original','size','type','url'];
}
