<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Transformers\CategoryTransformer;
use App\Repositories\CategoryRepository;

class CategoryController extends BaseController
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        parent::__construct();
        
        $this->categoryRepository = $categoryRepository;

        $this->middleware('blog.api',['except' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = $this->categoryRepository->getPostByPaginate($request);

        return $this->response->paginator($categories, new CategoryTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if ( $this->categoryRepository->checkUnique('slug',$data['slug'],0) ){
            $this->categoryRepository->store($data);
            return $this->response->noContent()->setStatusCode(200);    
        }else{
            return $this->response->array($this->errorMsg[10001]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->getById($id);

        return $this->response->item($category, new CategoryTransformer);
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
        $data = $request->all();

        if ( $this->categoryRepository->checkUnique('slug', $data['slug'], $id) ){
            $this->categoryRepository->update($id,$data);
            return $this->response->noContent()->setStatusCode(200);    
        }else{
            return $this->response->array($this->errorMsg[10001]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->categoryRepository->destroy($id);

        return $this->response->noContent()->setStatusCode(200);
    }
}
