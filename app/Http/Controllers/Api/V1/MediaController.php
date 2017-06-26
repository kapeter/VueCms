<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Repositories\MediaRepository;
use App\Transformers\MediaTransformer;

class MediaController extends BaseController
{
    protected $mediaRepository;

    public function __construct(MediaRepository $mediaRepository)
    {
        parent::__construct();
        
        $this->mediaRepository = $mediaRepository;

        $this->middleware('blog.api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * make a new directory
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $path = $request->get('path');

        $this->mediaRepository->make($path);

        return $this->mediaRepository->all();
    }

    /**
     * get all directories
     *
     * @return \Illuminate\Http\Response
     */
    public function folders()
    {
        return $this->mediaRepository->all();
    }

    /**
     * upload file
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $path = str_replace(',','/',$request->get('dict'));
        $file = $request->file('file');

        $res = $this->mediaRepository->store($path, $file);

        if (!$res){
            return $this->response->array($this->errorMsg[10007]);
        }else{
            return $res;
        }

    }

    /**
     * delete file
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $path = $request->get('path');

        $res = $this->mediaRepository->delFile($path);

        if (!$res){
            return $this->response->array($this->errorMsg[10008]);
        }else{
            return $this->response->array($this->errorMsg[10000]);
        }

    }

}