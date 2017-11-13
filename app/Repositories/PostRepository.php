<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Http\Request;

/**
*  Post Repository
*/
class PostRepository 
{
	use BaseRepository;

	protected $model;
	
	public function __construct(Post $post)
	{
		$this->model = $post;
	}

	/**
	*  get Post with Paginate
	*
	*  @param  \Illuminate\Http\Request  $request
	*/
	public function getPostByPaginate(Request $request)
	{
		$result = $this->model;

        if ($this->reqIsFromFront($request)){
            $result = $result->whereNotNull('published_at');
        }

        if (isset($request->category) && $request->category != 0){
        	$result = $result->where('category_id', $request->category);
        }

        if (isset($request->recommend)){
        	$result = $result->where('recommend', 'like', '%'.$request->recommend.'%');
        }

        if (isset($request->filter)){
        	$result = $result->where('title', 'like', '%'.$request->filter.'%');
        }

        if ( isset($request->sort) ){
            $orderby = explode('|', $request->sort);
            $result = $result->orderBy($orderby[0], $orderby[1]);
        }else{
        	$result = $result->orderBy('published_at', 'desc');
        }

        $per_page = isset($request->per_page) ? $request->per_page : 10;

        return $result->paginate($per_page);
	}


	/**
	*  get unique slug
	*
	*  @param  \Illuminate\Http\Request  $request
	*/
	public function getUniqueSlug($slug, $id)
	{
		$result = $this->model->withTrashed()->where('slug', 'like', $slug.'%');

		if ($id != null){
			$result = $result->where('id', '!=', $id);
		}
		$count = $result->count();

        return ($count != 0) ? $slug.'-'.($count + 1) : $slug; 
	}
}