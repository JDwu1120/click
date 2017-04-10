<?php

namespace App\Http\Controllers;

use App\dto\Operate;
use App\Service\Imploment\AdminService;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminController extends Controller
{
    public $admin;

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->admin = new AdminService();
    }
}
