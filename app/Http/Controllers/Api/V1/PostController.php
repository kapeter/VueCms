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
        parent::__construct();
        
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

        $user = $this->getCurrentUser($request);

        $data = array_merge($request->all(),
            [
                'slug' => $slug,                
                'user_id' => $user->id,
                'last_user_id' => $user->id,
                'tag' => 'tag',
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
    public function show(Request $request, $id)
    {
        $post = $this->postRepository->getById($id);

        // 如果来自前端，统计阅读量
        if ($this->reqIsFromFront($request)){
           $this->postRepository->update($id,['view_count' => $post->view_count + 1]); 
        }
        
        if (isset($post)){
            return $this->response->item($post, new PostTransformer);
        }else{
            return $this->response->array($this->errorMsg[10012]);
        }
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

        $user = $this->getCurrentUser($request);

        $data = array_merge($request->all(),
            [
                'slug' => $slug,                
                'last_user_id' => $user->id,
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

    /**
     * Change the post's publish state
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request,$id)
    {

        $data = [
            'published_at' => $request->is_publish ? Carbon::now() : null
        ];

        $this->postRepository->update($id,$data);

        return $this->response->noContent()->setStatusCode(200);
    }
}
