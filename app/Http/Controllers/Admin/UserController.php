<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\AdminService;
use App\Tools\Loader;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller {

    protected $adminService;

    public function __construct() {
        $this->adminService = Loader::getService(AdminService::class);
    }

    public function getList() {

    }

    public function add() {

    }

    public function edit() {

    }

    public function changeStatus() {

    }

    public function delete() {

    }

    public function deleteAll() {

    }
}
