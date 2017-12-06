<?php

namespace App\Repositories;

use App\Models\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
*  Category Repository
*/
class MailRepository 
{
	use BaseRepository;

	protected $model;
	
	public function __construct(Mail $mail)
	{
		$this->model = $mail;
	}

    /**
     * 根据系统设定的频率，检查用户发送的频率是否过快
     *
     * 
     * @return Boolean
     */
	public function checkRate($userIp) 
	{
        $mailRate = config('mail.rate');

		$lastTime =  date('Y-m-d H:i:s',strtotime("-" . $mailRate . " minute"));

		$result = $this->model->where([
			['user_ip', '=', $userIp],
			['created_at', '>', $lastTime]
		])->count();

		if ( $result != 0){
			return false;
		}else{
			return true;
		}
	}
}