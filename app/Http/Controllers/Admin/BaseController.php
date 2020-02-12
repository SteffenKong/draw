<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Flysystem\Config;

/**
 * Class BaseController
 * @package App\Http\Controllers\Admin
 * 后台基础控制器
 */
class BaseController extends Controller {

    protected $pageSize;

    public function __construct() {
        $this->pageSize = \config('draw.pageSize');
    }
}
