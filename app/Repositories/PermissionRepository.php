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

    /**
     * 从关系表中将该权限删除
     *
     * @param int $id 权限ID
     * @return null
     */
	public function delRelation($id)
	{
		DB::table($this->relation_table)->where('permission_id', $id)->delete();
	}


    /**
     * 提取角色权限信息
     *
     * @param int $id 角色id
     * @return array
     */
	public function getPermissionByRoleId($id)
	{
		$permissions = $this->all();

		$result = [];

		foreach ($permissions as $permission) {
			$relation = DB::table($this->relation_table)
							->where([
								['role_id', '=', $id],
								['permission_id', '=', $permission->id]
							])->first();
			$relation = $this->object_to_array($relation);
			array_push($result, array_merge($permission->toArray(), $relation));
		}

		return $result;
	}
}