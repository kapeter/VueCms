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
    public function all()
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
        
        return $this->mediaRepository->store($path, $file);

    }

}
