<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Admin
 * @package App\Model
 * 管理员模型
 */
class Admin extends Model {

    protected $primaryKey = 'id';

    protected $table = 'admin';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'account',
        'password',
        'status',
        'login_setting',
        'created_at',
        'updated_at'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * 与管理员信息附属表的一对一关联
     */
    public function adminInfo() {
        return $this->hasOne(AdminInfo::class,'admin_id','id');
    }
}
