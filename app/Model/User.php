<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Model
 * 用户模型
 */
class User extends Model {

    protected $table = 'user';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'number',
        'status',
        'is_draw',
        'draw_time',
        'created_at',
        'updated_at'
    ];
}
