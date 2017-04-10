<?php

namespace App\Http\Controllers;

use App\Service\Imploment\ArticleService;
use Illuminate\Http\Request;

use App\Http\Requests;

class TestController extends Controller
{
    public function test(){
        $brief = new ArticleService();
        echo $brief->brief(1);
    }
}
