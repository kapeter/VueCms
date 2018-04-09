<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
*  Category Repository
*/
class CommentRepository 
{
	use BaseRepository;

	protected $model;
	
	public function __construct(Comment $comment)
	{
		$this->model = $comment;
	}
}