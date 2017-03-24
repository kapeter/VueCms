<?php

namespace App\Repositories;

use App\User;
use Illuminate\Http\Request;

/**
*  User Repository
*/
class UserRepository 
{
	use BaseRepository;

	protected $model;
	
	public function __construct(User $user)
	{
		$this->model = $user;
	}
}