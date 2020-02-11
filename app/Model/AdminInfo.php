<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminInfo
 * @package App\Model
 * 管理员附属信息模型
 */
class AdminInfo extends Model {
    protected $primaryKey = 'id';

    protected $table = 'admin_info';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'admin_id',
        'email',
        'phone',
        'created_at',
        'updated_at'
    ];
}
