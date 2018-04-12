<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $permission) {
        return [
        	'id'   		    => $permission['id'],
            'route'         => $permission['route'],
            'title'         => $permission['title'],
            'description'   => $permission['description'],
            'is_except'     => $permission['is_except'],
            'created_at'    => $permission['created_at']->toDateTimeString(),
        ];
    }
}