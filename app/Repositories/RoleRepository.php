<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
*  Role Repository
*/
class RoleRepository 
{
	use BaseRepository;

	protected $model;

	protected $relation_table = 'permission_role';
	
	public function __construct(Role $role)
	{
		$this->model = $role;
	}

	// 设置权限
	public function setPermission($id, $data)
	{	
		foreach ($data as $item) {
			$relation = DB::table($this->relation_table)
							->where([
								['role_id', '=', $id],
								['permission_id', '=', $item->id]
							]);
			if (!isset($relation)){
				$this->insertRelationTable($id, $item);
			}else{
				$relation->update(
					[
						'can_create'    => isset($item->can_create) ? $item->can_create : false,
						'can_browser'   => isset($item->can_browser) ? $item->can_browser : false, 
						'can_edit'    	=> isset($item->can_edit) ? $item->can_edit : false, 
						'can_delete'    => isset($item->can_delete) ? $item->can_delete : false, 
					]
				);
			}
		}
	}

	//获取权限
	public function getPermission($id, $list)
	{
		//如果有未加入的权限，加入进去
		$relation = [];
		foreach ($list as $item){
			$temp = DB::table($this->relation_table)
							->where([
								['role_id', '=', $id],
								['permission_id', '=', $item->id]
							])->first();
			if (!isset($temp)){
				$temp = $this->insertRelationTable($id, $item);
			}		
			array_push($relation, $temp);
		}

		return $relation;
	}

	//插入新的权限
	public function insertRelationTable($id, $item)
	{
		return DB::table($this->relation_table)->insert(
			[
				'role_id'       => $id,
				'permission_id' => $item->id,
				'can_create'    => isset($item->can_create) ? $item->can_create : false,
				'can_browser'   => isset($item->can_browser) ? $item->can_browser : false, 
				'can_edit'    	=> isset($item->can_edit) ? $item->can_edit : false, 
				'can_delete'    => isset($item->can_delete) ? $item->can_delete : false, 
			]
		);			
	}

	//从关系表中将该角色删除
	public function delRelation($id)
	{
		DB::table($this->relation_table)->where('role_id', $id)->delete();
	}


	//判断该角色下是否有用户
	public function hasUser($id)
	{
		$role = $this->getById($id);

		return $role->users->count() != 0 ? true : false;
	}
}