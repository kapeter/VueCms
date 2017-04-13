<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
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
        $slug = isset($request->slug) ? $request->slug : translug($request->title);

        $slug = $this->postRepository->getUniqueSlug($slug,null);

        $data = array_merge($request->all(),
            [
                'slug' => $slug,                
                'user_id' => $request->user->id,
                'last_user_id' => $request->user->id,
                'cover_img' => 'adsas',
                'tag' => 'tag',
                'is_draft' => isset($request->isPublish) ? false : true,
                'published_at' => isset($request->isPublish) ? Carbon::now() : null
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
        $slug = isset($request->slug) ? $request->slug : translug($request->title);

        $slug = $this->postRepository->getUniqueSlug($slug, $id);

        $data = array_merge($request->all(),
            [
                'slug' => $slug,                
                'last_user_id' => $request->user->id,
                'is_draft' => isset($request->isPublish) ? false : true,
                'published_at' => isset($request->isPublish) ? Carbon::now() : null
            ]
        );

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
