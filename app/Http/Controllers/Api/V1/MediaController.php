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
    public function newDirectory(Request $request)
    {

    }

}
