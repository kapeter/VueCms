<?php

namespace App\Repositories;

use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
*  Category Repository
*/
class UserLogRepository 
{
	use BaseRepository;

	protected $model;
	
	public function __construct(UserLog $log)
	{
		$this->model = $log;
	}
}