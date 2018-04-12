<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\OperationLog;

class OperationLogTransformer extends TransformerAbstract
{
    public function transform(OperationLog $log) {
        return [
        	'id'   		    => $log['id'],
            'controller'    => $log['controller'],
            'action'        => $log['action'],
            'querystring'   => $log['querystring'],
	        'username'      => $log['username'],
            'ip'            => $log['ip'],
	        'created_at'    => $log['created_at']->toDateTimeString(),
        ];
    }
}