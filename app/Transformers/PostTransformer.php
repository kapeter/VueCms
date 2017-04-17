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
            'category_id'   => $post['category_id'],
	        'last_user'     => $post->lastUser->name,
	        'slug'          => $post['slug'],
	        'cover_img'     => $post['cover_img'],
	        'description'   => $post['description'],
            'is_publish'    => isset($post['published_at']) ? true : false,
            'published_at'  => $post['published_at'],
	        'updated_at'    => $post['updated_at'],
            'created_at'    => $post['created_at']
        ];
    }
}