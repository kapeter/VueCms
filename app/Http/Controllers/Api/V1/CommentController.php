<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repositories\CommentRepository;
use App\Transformers\CommentTransformer;

class CommentController extends BaseController
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        parent::__construct();
        
        $this->commentRepository = $commentRepository;

        $this->middleware('blog.api',['except' => ['index', 'store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comments = $this->commentRepository->getCommentByPaginate($request);

        return $this->response->paginator($comments, new CommentTransformer);
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
                'comment_cotent' => htmlentities($request->comment_cotent),
                'comment_author_ip' => $request->ip()
            ]
        );

        $this->commentRepository->store($data);

        return $this->response->noContent()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->commentRepository->destroy($id);

        return $this->response->noContent()->setStatusCode(200);
    }
}
