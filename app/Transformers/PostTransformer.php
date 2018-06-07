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
            'category'      => $post->category,
	        'slug'          => $post['slug'],
	        'cover_img'     => $post['cover_img'],
	        'description'   => $post['description'],
            'recommend'     => $post['recommend'],
            'is_publish'    => isset($post['published_at']) ? true : false,
            'published_at'  => $post['published_at']->toDateTimeString(),
            'view_count'    => $post['view_count'],
	        'updated_at'    => $post['updated_at']->toDateTimeString(),
            'created_at'    => $post['created_at']->toDateTimeString()
        ];
    }
}