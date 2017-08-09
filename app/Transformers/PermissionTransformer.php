<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $permission) {
        return [
        	'id'   		    => $permission['id'],
            'parent_id'     => $permission['parent_id'],
            'url'           => $permission['url'],
            'title'         => $permission['title'],
	        'type'          => $permission['type'],
            'description'   => $permission['description'],
	        'is_menu'       => $permission['is_menu'],
            'icon'          => $permission['icon'],
            'order'         => $permission['order'],
            'created_at'    => $permission['created_at'],
        ];
    }
}