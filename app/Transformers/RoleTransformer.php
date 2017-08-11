<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Role;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role) {
        return [
        	'id'   		    => $role['id'],
            'name'          => $role['name'],
            'title'         => $role['title'],
            'description'   => $role['description'],
            'created_at'    => $role['created_at'],
        ];
    }
}