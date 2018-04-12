<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\UserLog;

class UserLogTransformer extends TransformerAbstract
{
    public function transform(UserLog $log) {
        return [
        	'id'   		  => $log['id'],
            'username'    => $log['username'],
            'email'       => $log['email'],
            'ip'          => $log['ip'],
	        'created_at'  => $log['created_at']->toDateTimeString(),
        ];
    }
}