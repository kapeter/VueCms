<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\V1\BaseController;

class SettingController extends BaseController
{
	protected $sysInfo;

   protected $dbInfo;

   public function __construct()
   {
        parent::__construct();

   }

	public function system()
	{
		$this->sysInfo = [
			'system' => ['label' => '操作系统', 'value' => php_uname('s').' '.php_uname('r') ],
         'server_name' => ['label' => '服务器软件', 'value' =>  $_SERVER['SERVER_SOFTWARE'] ],
         'php'    => ['label' => 'PHP版本', 'value' => PHP_VERSION ],
			'http_host' => ['label' => '后台域名', 'value' => $_SERVER["HTTP_HOST"] ]
		];

      $query = DB::select('select version()');

      $query = $this->object_to_array($query);      

      $this->dbInfo = [
         'db_database' => ['label' => '数据库名', 'value' => isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : '暂无', ],
         'db_connection' => ['label' => '数据库软件', 'value' => isset($_SERVER['DB_CONNECTION']) ? $_SERVER['DB_CONNECTION'] : '暂无' ],
         'db_version' => ['label' => '数据库版本', 'value' => $query[0]['version()'] ],
      ];

      $data = [
         'system'   => $this->sysInfo,
         'database' => $this->dbInfo
      ];

		return $this->response->array($data);
	}
}
