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
            'status'        => $user['status'],
            'role'          => $user->role,
            'created_at'    => $user['created_at']->toDateTimeString()
        ];
    }
}