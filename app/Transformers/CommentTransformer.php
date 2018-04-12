<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Comment;

class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment) {
        return [
            'id'                   => $comment['id'],
        	'comment_type'   	   => $comment['comment_type'],
            'comment_relation_id'  => $comment['comment_relation_id'],
            'comment_author'       => $comment['comment_author'],
	        'comment_author_email' => $comment['comment_author_email'],
	        'comment_author_url'   => $comment['comment_author_url'],
            'comment_author_ip'    => $comment['comment_author_ip'],
            'comment_content'      => $comment['comment_content'],
            'parent'               => $comment['parent'],
            'relation'             => $comment['relation'],
            'created_at'           => $comment['created_at']->toDateTimeString()
        ];
    }
}