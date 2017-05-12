<?php

namespace App\Repositories;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
*  Category Repository
*/
class LogRepository 
{
	use BaseRepository;

	protected $model;
	
	public function __construct(Log $log)
	{
		$this->model = $log;
	}
}