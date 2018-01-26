<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'model',
        'slug',
        'description',
    ];


    public function posts()
    {
         return $this->hasMany(Post::class, 'category_id');
    }
}
