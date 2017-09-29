<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
*  Setting Repository
*/
class SettingRepository 
{
	use BaseRepository;

	protected $model;
	
	public function __construct(Setting $setting)
	{
		$this->model = $setting;
	}

	public function getAllConf($request)
	{
		$result = $this->model;
        if ($this->reqIsFromFront($request)){
            $result = $result->where('is_public', true);
        }
        
        return $result->get();
	}
}