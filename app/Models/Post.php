<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'last_user_id',
        'category_id',
        'title',
        'slug',
        'cover_img',
        'content',
        'description',
        'is_draft',
        'tag',
        'view_count',
        'published_at',
    ];
     /**
     * Get the user for the blog article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
	 * Get the last user for the blog article
	 */
	public function lastUser(){
	    return $this->belongsTo(\App\User::class, 'last_user_id');
	}
}
