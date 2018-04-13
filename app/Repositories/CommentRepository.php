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

	/**
	*  get Comment with Paginate
	*
	*  @param  \Illuminate\Http\Request  $request
	*/
	public function getCommentByPaginate(Request $request)
	{
		$result = $this->model;

        $per_page = isset($request->per_page) ? $request->per_page : 10;

       	if (isset($request->comment_relation_id)) {
       		$result = $result->where([
			    ['comment_type', '=', $request->comment_type],
			    ['comment_relation_id', '=', $request->comment_relation_id],
			]);
       	}

        $result = $result->orderBy('created_at', 'desc');

        $result = $result->paginate($per_page);

        foreach ($result as $comment) {
        	$table = $comment->comment_type.'s';
			if ( Schema::hasTable($table) ){
				$comment['relation'] = DB::table($table)->where('id', $comment->comment_relation_id)->first();
			}else{
				$comment['relation'] = null;
			}   
			// 获取父评论信息   	
			if ($comment->comment_parent_id != 0){
				$comment['parent'] = $this->getById($comment->comment_parent_id);
			}
        }

        

        return $result;
	}
}