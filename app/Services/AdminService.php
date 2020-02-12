<?php
namespace App\Service;

use App\Model\Admin;
use App\Model\AdminInfo;
use Carbon\Carbon;
use App\Tools\Rsa\Rsa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


/**
 * Class AdminService
 * @package App\Service
 */
class AdminService {

    /**
     * @param $account
     * @param $password
     * @return array|bool
     * 登录查询
     */
    public function login($account,$password) {
        //解密
        $rsa = new Rsa();
        $rsa->setPrivateKey(\config('draw.privateKey'));
        $pass = $rsa->decrpytByPrivateKey($password);
        $admin = Admin::where('account',$account)->first();
        if(!$admin) {
            return false;
        }
        if(!Hash::check($pass,$admin->password)) {
            return false;
        }

        if(Hash::needsRehash($admin->password))   {
            $hashPass = Hash::make($pass);
            Admin::where('account',$account)->update([
                'password' => $pass,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
        }

        return [
            'id' => $admin->id,
            'account' => $admin->account
        ];
    }

    /**
     * @param $userId
     * @return mixed
     * 检测是否可登录
     */
    public function checkStatus($userId) {
        return Admin::where('user',$userId)->value('status');
    }



    /**
     * @param $pageSize
     * @param $where
     * @return array
     * 获取列表
     */
    public function getList($pageSize,$where) {
        $return = [];
        $paginate = Admin::when(!empty($where['account']),function($query) use ($where) {
            return $query->where('account','like','%'.$where['account'].'%');
        })->when($where['status'] != -1,function($query) use ($where) {
            return $query->where('status',$where['status']);
        })->when(!empty($where['email']),function($query) use ($where) {
            return $query->whereHas(AdminInfo::class,function($q) use ($where) {
                return $q->where('email','like','%'.$where['email'].'%');
            });
        })->when(!empty($where['phone']),function($query) use ($where) {
            return $query->whereHas(AdminInfo::class,function($q) use ($where) {
                return $q->where('phone','like','%'.$where['phone'].'%');
            });
        })->orderBy('created_at','desc')->paginate($pageSize);

        foreach ($paginate ?? [] as $admin) {
            $return[] = [
                'id' => $admin->id,
                'account' => $admin->account,
                'status' => $admin->status,
                'loginSetting' => $admin->login_setting,
                'email' => optional($admin->adminInfo)->email,
                'phone' => optional($admin->adminInfo)->phone,
                'createdAt' => $admin->created_at,
                'updatedAt' => $admin->updated_at
            ];
        }
        return $return;
    }


    /**
     * @param $account
     * @param $password
     * @param $status
     * @param $loginSetting
     * @param $phone
     * @param $email
     * @return bool
     * 增加管理员
     */
    public function add($account,$password,$status,$loginSetting,$phone,$email) {
        $result = false;
        //解密
        $rsa = new Rsa();
        $rsa->setPrivateKey(\config('draw.privateKey'));
        $pass = $rsa->decrpytByPrivateKey($password);
        DB::beginTransaction();
        try {
            $result1 = Admin::create([
                'account' => $account,
                'password' => Hash::make($pass),
                'status' => $status,
                'login_setting' => $loginSetting,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

            $result2 = AdminInfo::create([
                'admin_id' => $result1->id,
                'email' => $email,
                'phone' => $phone,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

            if($result1 && $result2) {
                $result = true;
            }
        }catch (\Exception $e) {
            DB::rollBack();
        }

        if(!$result) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }


    /**
     * @param $adminId
     * @param $account
     * @param $password
     * @param $status
     * @param $loginSetting
     * @param $phone
     * @param $email
     * @return bool
     * 编辑管理员
     */
    public function edit($adminId,$account,$password,$status,$loginSetting,$phone,$email) {
        $result = false;
        //解密
        $rsa = new Rsa();
        $rsa->setPrivateKey(\config('draw.privateKey'));
        $pass = $rsa->decrpytByPrivateKey($password);
        DB::beginTransaction();
        try {
            $result1 = Admin::where('id',$adminId)->update([
                'account' => $account,
                'password' => Hash::make($pass),
                'status' => $status,
                'login_setting' => $loginSetting,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

            $result2 = Admin::where('admin_id',$adminId)->update([
                'email' => $email,
                'phone' => $phone,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
            if($result1 && $result2) {
                $result = true;
            }
        }catch (\Exception $e) {
            DB::rollBack();
        }

        if(!$result) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }


    /**
     * @param $adminId
     * @return array
     * 获取管理员详细信息
     */
    public function getOne($adminId) {
        $return = [];
        $admin = Admin::where('id',$adminId)->first();
        if($admin) {
            $return = [
                'id' => $admin->id,
                'account' => $admin->account,
                'status' => $admin->status,
                'loginSetting' => $admin->login_setting,
                'email' => optional($admin->adminInfo)->email,
                'phone' => optional($admin->adminInfo)->phone,
                'createdAt' => $admin->created_at,
                'updatedAt' => $admin->updated_at
            ];
        }
        return $return;
    }

    /**
     * @param $adminId
     * @return bool
     * 删除管理员
     */
    public function delData($adminId) {
        $result = false;
        DB::beginTransaction();
        try {
            $result1 = Admin::where('id',$adminId)->delete();
            $result2 = AdminInfo::where('admin_id',$adminId)->delete();
            if($result1 && $result2) {
                $result = true;
            }
        }catch (\Exception $e) {
            DB::rollBack();
        }
        if(!$result) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }


    /**
     * @param $adminId
     * @param $fieldName
     * @param $value
     * @return bool
     * 查询指定数据的字段是否存在
     */
    public function checkFieldNameIsExistsExceptId($adminId,$fieldName,$value) {
        $result = true;
        /* @var Admin $admin */
        $admin = new Admin();
        /* @var AdminInfo $adminInfo*/
        $adminInfo = new AdminInfo();
        if(in_array($fieldName,$admin->fillable)) {
            $result = Admin::where('id','!=',$adminId)->where($fieldName,$value)->count();
        }
        if(in_array($fieldName,$adminInfo->fillable)) {
            $result = AdminInfo::where('admin_id','!=',$adminId)->where($fieldName,$value)->count();
        }
        return $result;
    }

    /**
     * @param $adminId
     * @return mixed
     * 更改状态
     */
    public function changeStatus($adminId) {
        $status = 0;
        $statusRes = Admin::where('id',$adminId)->value('status');
        if(!$statusRes) {
            $status = 1;
        }
        return Admin::where('id',$adminId)->update([
            'status' => $status,
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
    }
}
