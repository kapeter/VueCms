<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'url',
        'title',
        'type',
        'description',
        'is_menu',
        'icon',
        'order'
    ];
}
