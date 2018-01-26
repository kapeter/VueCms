<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
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
