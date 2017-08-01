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

	/**
	*  get User with Paginate
	*
	*  @param  \Illuminate\Http\Request  $request
	*/
	public function getUserByPaginate(Request $request)
	{
		$result = $this->model;

        if (isset($request->filter)){
        	$result = $result->where('title', 'like', '%'.$request->filter.'%');
        }

        if ( isset($request->sort) ){
            $orderby = explode('|', $request->sort);
            $result = $result->orderBy($orderby[0], $orderby[1]);
        }

        $per_page = isset($request->per_page) ? $request->per_page : 10;

        return $result->paginate($per_page);
	}


	/**
	*  check the uniqueness of email
	*
	*  @param  \Illuminate\Http\Request  $request
	*/
	public function checkUniqueEmail($id, $email)
	{
		$count = $this->model->where('email',$email)->where('id','<>',$id)->count();

        return ($count != 0) ? false : true; 
	}
}