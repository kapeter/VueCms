<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'user_logs';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'username',
        'email',
        'ip',
    ];
}
