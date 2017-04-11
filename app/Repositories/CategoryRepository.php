<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Http\Request;

/**
*  Category Repository
*/
class CategoryRepository 
{
	use BaseRepository;

	protected $model;
	
	public function __construct(Category $category)
	{
		$this->model = $category;
	}
}