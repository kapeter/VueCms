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
	
	public function __construct(Permission $permission)
	{
		$this->model = $permission;
	}
}