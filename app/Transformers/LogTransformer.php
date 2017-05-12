<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Log;

class LogTransformer extends TransformerAbstract
{
    public function transform(Log $log) {
        return [
        	'id'   		    => $log['id'],
            'controller'    => $log['controller'],
            'action'        => $log['action'],
            'querystring'   => $log['querystring'],
	        'username'      => $log['username'],
            'ip'            => $log['ip'],
	        'created_at'    => $log['created_at'],
        ];
    }
}