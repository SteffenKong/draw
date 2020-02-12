<?php
namespace App\Service;

use App\Model\User;
use Carbon\Carbon;


/**
 * Class UserService
 * @package App\Service
 */
class UserService {

    public function getList($pageSize,$where) {

    }

    /**
     * @param $name
     * @param $number
     * @param $status
     * @return mixed
     * 添加组员信息
     */
    public function add($name,$number,$status) {
        return User::create([
            'name' => $name,
            'number' => $number,
            'status' => $status,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
    }


    /**
     * @param $userId
     * @param $name
     * @param $status
     * @param $number
     * @return mixed
     * 编辑组员信息
     */
    public function edit($userId,$name,$status,$number) {
        return User::where('id',$userId)->update([
            'name' => $name,
            'status' => $status,
            'number' => $number,
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
    }


    /**
     * @param $userId
     * @return mixed
     * 写入抽签状态
     */
    public function setDrawFlag($userId) {
        return User::where('id',$userId)->update([
            'is_draw' => 1,
            'draw_time' => Carbon::now()->toDateTimeString()
        ]);
    }


    /**
     * @param $userId
     * @return mixed
     * 改变状态
     */
    public function changeStatus($userId) {
        $status = 0;
        $statusRes = User::where('id',$userId)->value('status');
        if(!$statusRes) {
            $status = 1;
        }
        return User::where('id',$userId)->update(['status' => $status]);
    }


    /**
     * @param $userId
     * @return mixed
     * 删除组员
     */
    public function delData($userId) {
        return User::where('id',$userId)->delete();
    }


    /**
     * @param array $userIds
     * @return mixed
     * 批量删除组员
     */
    public function delAll(array $userIds) {
        return User::whereIn('id',$userIds)->delete();
    }


    /**
     * @return array
     * 随机抽取一个组员
     */
    public function drawUser() {
        $return = [];
        $total = User::count() - 1;
        $skip  = mt_rand(0,$total);
        $book = User::select('id','name')->skip($skip)->take(1)->first();
        if($book) {
            $return = [
                'id' => $book->id,
                'name' => $book->name
            ];
        }
        return $return;
    }
}
