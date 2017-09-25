<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

        $result = $result->orderBy('id', 'desc');

        $per_page = isset($request->per_page) ? $request->per_page : 10;

        $result = $result->paginate($per_page);

        foreach ($result as $value) {
        	$value['detail'] = $this->getDetailById($value->id, $value->model);
        }

        return $result;

	}

	public function getDetailById($id,$model)
	{
		$table = $model.'s';
		if ( Schema::hasTable($table) ){
			$query = DB::table($table)->where('category_id', $id)->whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();

			if ( $count = $query->count() ){
				return [
					'count'      => $count,
					'model'      => $model,
					'article'    => $query->first(),
				];
			}
		}

		return [
			'count'      => 0,
			'model'      => $model,
			'article'    => '',
		];

	}
}