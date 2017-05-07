<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'article',
        'article/*',
        'homepage',
        'getToken',
        'getInfo',
        'getLogin',
        'getToken',
        'addArticle',
        'showOneArticle',
        'showArticle',
        'showOneTag',
        'showOneCategory',
        'verifySend',
        'userRegister',
        'userLogin',
        'viewArticle',
        'comment',
        'showUserMsg',
        'agreeComs'
    ];
}
