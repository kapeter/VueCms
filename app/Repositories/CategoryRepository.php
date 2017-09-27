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
        	$table = $value->model.'s';
			if ( Schema::hasTable($table) ){
				$query = DB::table($table)->where('category_id', $value->id)->whereNull('deleted_at')->orderBy('updated_at', 'desc');

				if ($this->reqIsFromFront($request)){
		            $query = $query->whereNotNull('published_at');
		        }
		        $query = $query->get();

				if ( $count = $query->count() ){
					$value['detail'] = ['count' => $count, 'model' => $value->model, 'article' => $query->first()];
				}else{
					$value['detail'] = ['count' => 0, 'model' => $value->model, 'article' => ''];
				}
			}else{
				$value['detail'] = ['count' => 0, 'model' => $value->model, 'article' => ''];
			}        	
        }

        return $result;

	}
}