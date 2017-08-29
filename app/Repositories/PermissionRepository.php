<?php

namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
*  Category Repository
*/
class PermissionRepository 
{
	use BaseRepository;

	protected $model;

	protected $relation_table = 'permission_role'; 
	
	public function __construct(Permission $permission)
	{
		$this->model = $permission;
	}

	//从关系表中将该权限删除
	function delRelate($id)
	{
		DB::table($this->relation_table)->where('permission_id', $id)->delete();
	}
}