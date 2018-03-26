<?php

namespace App\Repositories;

use App\Models\OperationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
*  Category Repository
*/
class OperationLogRepository 
{
	use BaseRepository;

	protected $model;
	
	public function __construct(OperationLog $log)
	{
		$this->model = $log;
	}
}