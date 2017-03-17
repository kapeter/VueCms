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

        if ( isset($request->sort) ){
            $orderby = explode('|', $request->sort);
            $result = $result->orderBy($orderby[0], $orderby[1]);
        }
        
        $per_page = isset($request->per_page) ? $request->per_page : 10;

        return $result->paginate($per_page);
	}

	/**
     * Get the article record without draft scope.
     * 
     * @param  int $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }
    

    /**
     * Delete the draft article.
     *
     * @param int $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }

}