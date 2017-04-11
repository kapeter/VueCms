<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Category;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category) {
        return [
        	'id'   		    => $category['id'],
            'name'          => $category['name'],
            'parent_id'     => $category['parent_id'],
	        'slug'          => $category['slug'],
	        'model'         => $category['model'],
	        'description'   => $category['description'],
	        'updated_at'    => $category['updated_at'],
            'created_at'    => $category['created_at']
        ];
    }
}