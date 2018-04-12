<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment_type',
        'comment_relation_id',
        'comment_author',
        'comment_author_email',
        'comment_author_url',
        'comment_author_ip',
        'comment_content',
        'comment_parent_id'
    ];
}
