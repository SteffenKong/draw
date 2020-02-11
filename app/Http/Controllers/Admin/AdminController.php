<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\AdminService;
use App\Tools\Loader;
use Illuminate\Http\Request;

class AdminController extends Controller {

    /* @var AdminService $adminService */
    protected $adminService;

    public function __construct() {
        $this->adminService = Loader::getService(AdminService::class);
    }
}
