<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Transformers\PostTransformer;
use App\Repositories\PostRepository;

class PostController extends BaseController
{

    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;

        $this->middleware('blog.api',['except' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = $this->postRepository->getPostByPaginate($request);

        return $this->response->paginator($posts, new PostTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array_merge($request->all(),
            [
                'category_id' => 1,
                'slug' => '312312',                
                'user_id' => $request->user->id,
                'last_user_id' => $request->user->id,
                'cover_img' => 'adsas',
                'tag' => 'tag',
                'is_draft' => false,
                'view_count' => 2121
            ]
        );
        $this->postRepository->store($data);

        return $this->response->noContent()->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->postRepository->getById($id);

        return $this->response->item($post, new PostTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data =  $request->all();

        $this->postRepository->update($id,$data);

        return $this->response->noContent()->setStatusCode(200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postRepository->destroy($id);

        return $this->response->noContent()->setStatusCode(200);
    }
}
