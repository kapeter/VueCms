<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;

class SettingController extends BaseController
{
	protected $systemInfo;

   	public function system()
   	{
   		$this->systemInfo = [
   			'system' => ['label' => '操作系统', 'value' => php_uname('s').' '.php_uname('r') ],
   			'server_name' => ['label' => '服务器域名', 'value' => $_SERVER["HTTP_HOST"] ],
   			'php'    => ['label' => 'PHP版本', 'value' => PHP_VERSION ],

   		];
   		return $this->response->array($this->systemInfo);
   	}
}
