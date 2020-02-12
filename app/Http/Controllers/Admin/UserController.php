<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserAddRequest;
use App\Http\Requests\Admin\UserEditRequest;
use App\Http\Requests\Admin\UserIdRequest;
use App\Service\AdminService;
use App\Service\UserService;
use App\Tools\JsonResult;
use App\Tools\Loader;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 * 组员控制器
 */
class UserController extends BaseController {

    /* @var UserService $userService */
    protected $userService;

    public function __construct() {
        parent::__construct();
        $this->userService = Loader::getService(UserService::class);
    }


    /**
     * @param Request $request
     * @return false|string
     * 获取用户列表
     */
    public function getList(Request $request) {
        $where['name'] = $request->get('name');
        $where['number'] = $request->get('number');
        $where['status'] = $request->get('status',-1);
        $where['isDraw'] = $request->get('is_draw',-1);
        $where['drawTime'] = $request->get('drawTime',-1);
        list($data,$paginate) = $this->userService->getList($this->pageSize,$where);
        return jsonPrint('000','获取成功',$paginate->count(),$data);
    }


    /**
     * @param UserAddRequest $request
     * @return false|string
     * 录入组员
     */
    public function add(UserAddRequest $request) {
        $name = $request->get('name');
        $number = $request->get('number');
        $status = $request->get('status');

        if(!$this->userService->add($name,$number,$status)) {
            return jsonPrintMessage('001','组员录入失败!');
        }
        return jsonPrintMessage('000','组员录入成功');
    }


    /**
     * @param UserEditRequest $request
     * @return false|string
     * 编辑组员
     */
    public function edit(UserEditRequest $request) {
        $id = $request->get('id');
        $name = $request->get('name');
        $number = $request->get('number');
        $status = $request->get('status');

        if(!$this->userService->edit($id,$name,$number,$status)) {
            return jsonPrintMessage('001','组员编辑失败!');
        }
        return jsonPrintMessage('000','组员编辑成功');
    }


    /**
     * @param UserIdRequest $request
     * @return false|string
     * 更改组员可进行抽签状态
     */
    public function changeStatus(UserIdRequest $request) {
        $userId = $request->get('id');
        if(!$this->userService->changeStatus($userId)) {
            return jsonPrintMessage('001','组员状态编辑失败!');
        }
        return jsonPrintMessage('000','组员状态编辑成功');
    }


    /**
     * @param UserIdRequest $request
     * @return false|string
     * 删除组员
     */
    public function delete(UserIdRequest $request) {
        $userId = $request->get('id');
        if(!$this->userService->delData($userId)) {
            return jsonPrintMessage('001','组员删除失败!');
        }
        return jsonPrintMessage('000','组员删除成功');
    }


    /**
     * @param UserIdRequest $request
     * @return false|string
     * 组员批量删除
     */
    public function deleteAll(Request $request) {
        $userIds = $request->get('ids');
        if(!$this->userService->delAll($userIds)) {
            return jsonPrintMessage('001','组员批量删除失败!');
        }
        return jsonPrintMessage('000','组员批量删除成功');
    }


    /**
     * @param UserIdRequest $request
     * @return false|string
     * 设置抽签状态
     */
    public function setDrawFlag(UserIdRequest $request) {
        $userId = $request->get('id');
        if(!$this->userService->setDrawFlag($userId)) {
            return jsonPrintMessage('001','设置失败!');
        }
        return jsonPrintMessage('000','设置成功');
    }
}
