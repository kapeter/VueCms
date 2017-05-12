<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $fillable = [
        'controller',
        'action',
        'querystring',
        'username',
        'ip',
    ];
}
