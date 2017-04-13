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

	/**
	*  get Post with Paginate
	*
	*  @param  \Illuminate\Http\Request  $request
	*/
	public function getPostByPaginate(Request $request)
	{
		$result = $this->model;

        if (isset($request->model)){
        	$result = $result->where('model', $request->model);
        }

        $per_page = isset($request->per_page) ? $request->per_page : 10;

        $result = $result->paginate($per_page);

        foreach ($result as $value) {
        	$value['count'] = $this->getCountById($value->id);
        }
        return $result;

	}

	public function getCountById($id)
	{
		return $this->getById($id)->posts->count();
	}
}