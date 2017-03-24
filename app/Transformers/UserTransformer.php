<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user) {
        return [
        	'id'   		    => $user['id'],
            'email'         => $user['email'],
            'name'          => $user['name'],
	        'avatar'        => $user['avatar'],
	        'bio'           => $user['bio'],
	        'is_admin'      => $user['is_admin'],
            'status'        => $user['status'],
	        'updated_at'    => $user['updated_at'],
            'created_at'    => $user['created_at']
        ];
    }
}