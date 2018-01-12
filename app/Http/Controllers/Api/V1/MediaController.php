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
        $path = $request->get('path');

        $filesList = $this->mediaRepository->filesInThis($path);
        $foldersList = $this->mediaRepository->foldersInThis($path);

        $data = [];

        foreach ($foldersList as $value) {
            array_push($data,$this->mediaRepository->folderInfo($value));
        }

        foreach ($filesList as $value) {
            array_push($data,$this->mediaRepository->fileInfo($value));
        }

        return $data;
    }

    /**
     * make a new folder
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $path = $request->get('path');
        $fullPath = $path . '/' . $request->get('name');

        if (!$this->mediaRepository->folderIsExist($path, $fullPath)){
            $this->mediaRepository->make($fullPath);
            return $this->response->array($this->errorMsg[10000]);            
        }else{
            return $this->response->array($this->errorMsg[11002]);
        }
    }

    /**
     * upload file
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $path = '/'.str_replace(',','/',$request->get('dict'));
        $file = $request->file('file');

        $res = $this->mediaRepository->store($path, $file);

        if (!$res){
            return $this->response->array($this->errorMsg[11000]);
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
        $type = $request->get('type');
        $path = $request->get('path');

        if ($type == 'folder'){
            $res = $this->mediaRepository->delFolder($path);
        }else{
            $res = $this->mediaRepository->delFile($path);
        }

        if (!$res){
            return $this->response->array($this->errorMsg[11001]);
        }else{
            return $this->response->array($this->errorMsg[10000]);
        }

    }
}
