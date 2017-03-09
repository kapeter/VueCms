<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Post;

class PostTransformer extends TransformerAbstract
{
    public function transform(Post $post) {
        return [
        	'id'   		    => $post['id'],
            'title'         => $post['title'],
            'content'       => $post['content'],
	        'last_user'     => $post->lastUser->name,
	        'slug'          => $post['slug'],
	        'cover_img'     => $post['cover_img'],
	        'description'   => $post['description'],
	        'is_draft'      => false,
	        'published_at'  => $post['published_at']
        ];
    }
}