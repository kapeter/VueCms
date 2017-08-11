<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
*  Category Repository
*/
class RoleRepository 
{
	use BaseRepository;

	protected $model;
	
	public function __construct(Role $role)
	{
		$this->model = $role;
	}
}