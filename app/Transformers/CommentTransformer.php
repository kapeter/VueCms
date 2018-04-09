<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Comment;

class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment) {
        return [
        	'id'   		    => $comment['id'],
            'email'         => $comment['email'],
            'name'          => $comment['name'],
	        'avatar'        => $comment['avatar'],
	        'bio'           => $comment['bio'],
            'status'        => $comment['status'],
            'role'          => $comment->role,
            'created_at'    => $comment['created_at']
        ];
    }
}