<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationLog extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'operation_logs';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'controller',
        'action',
        'querystring',
        'username',
        'ip',
    ];
}
