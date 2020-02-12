<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminAddRequest;
use App\Http\Requests\Admin\AdminEditRequest;
use App\Http\Requests\Admin\LoginRequest;
use App\Service\AdminService;
use App\Tools\Loader;
use Illuminate\Http\Request;

/**
 * Class AdminController
 * @package App\Http\Controllers\Admin
 * 管理员控制器
 */
class AdminController extends BaseController {

    /* @var AdminService $adminService */
    protected $adminService;

    public function __construct() {
        parent::__construct();
        $this->adminService = Loader::getService(AdminService::class);
    }


    /**
     * @param Request $request
     * @return false|string
     * 获取管理员列表
     */
    public function getList(Request $request) {
        $where['status'] = $request->get('status',-1);
        $where['account'] = $request->get('account','');
        $where['email'] = $request->get('email','');
        $where['phone'] = $request->get('phone','');
        list($list,$paginate) = $this->adminService->getList($this->pageSize,$where);
        return jsonPrint('000','获取成功',$paginate->count(),$list);
    }


    /**
     * @param AdminAddRequest $request
     * @return false|string
     * 添加管理员
     */
    public function add(AdminAddRequest $request) {
        $data = $request->post();
        if(!$this->adminService->add($data['account'],$data['password'],$data['status'],$data['loginSetting'],$data['phone'],$data['email'])) {
            return jsonPrintMessage('001','添加失败!');
        }
        return jsonPrintMessage('000','添加成功');
    }


    /**
     * @param AdminEditRequest $request
     * @return false|string
     * 编辑管理员
     */
    public function edit(AdminEditRequest $request) {
        $data = $request->post();

        if($this->adminService->checkFieldNameIsExistsExceptId($data['id'],'account',$data['account'])) {
            return jsonPrintMessage('002','账号已存在!');
        }

        if($this->adminService->checkFieldNameIsExistsExceptId($data['id'],'email',$data['email'])) {
            return jsonPrintMessage('002','邮箱已存在!');
        }

        if($this->adminService->checkFieldNameIsExistsExceptId($data['id'],'phone',$data['phone'])) {
            return jsonPrintMessage('002','手机号码已存在!');
        }

        if(!$this->adminService->edit($data['id'],$data['account'],$data['password'],$data['status'],$data['loginSetting'],$data['phone'],$data['email'])) {
            return jsonPrintMessage('001','编辑失败!');
        }
        return jsonPrintMessage('000','编辑成功');
    }


    /**
     * @param int $adminId
     * @return false|string
     * 删除管理员
     */
    public function delete(int $adminId) {
        if(!$this->adminService->delData($adminId)) {
            return jsonPrintMessage('001','删除失败!');
        }
        return jsonPrintMessage('000','删除成功');
    }

    /**
     * @param int $adminId
     * @return false|string
     * 编辑管理员状态
     */
    public function changeStatus(int $adminId) {
        if(!$this->adminService->changeStatus($adminId)) {
            return jsonPrintMessage('001','编辑失败!');
        }
        return jsonPrintMessage('000','编辑成功');
    }


    /**
     * @param int $adminId
     * @return false|string
     * 获取管理员详细信息
     */
    public function one(int $adminId) {
        $one = $this->adminService->getOne($adminId);
        return jsonPrint('000','获取成功',$one);
    }
}
