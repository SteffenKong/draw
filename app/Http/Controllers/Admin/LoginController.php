<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Model\Admin;
use App\Service\AdminService;
use App\Tools\Loader;

/**
 * Class LoginController
 * @package App\Http\Controllers\Admin
 * 后台登录控制器
 */
class LoginController extends Controller
{


    /**
     * @param LoginRequest $request
     * @return false|string
     * 登录
     */
    public function sign(LoginRequest $request) {
        $account = $request->get('account');
        $password = $request->get('password');
        /* @var AdminService $adminService */
        $adminService = Loader::getService(AdminService::class);

        if(!$adminService->login($account,$password)) {
            return jsonPrintMessage('001','登录失败!');
        }
        return jsonPrintMessage('000','登录成功');
    }


    /**
     * @return false|string
     * 获取公钥
     */
    public function getPublicKey() {
        return jsonPrint('000','获取成功',['publicKey'=>\config('draw.publicKey')]);
    }
}
