<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

/**
*  Category Repository
*/
class MediaRepository 
{

	protected $tempPath = 'temp';

	protected $mimeTypes;  //mime_type array

	public function __construct()
	{
		$this->mimeTypes = explode(',',config('filesystems.mime_type'));
	}

	// make a new folder
	public function make($directory)
	{
		return Storage::makeDirectory($directory);	
	}

    /**
     * get files list in current folders
     *
     * @return Array
     */
	public function filesInThis($directory)
	{
		return Storage::files($directory);
	}

    /**
     * get folders list in current folders
     *
     * @return Array
     */
	public function foldersInThis($directory)
	{
		return Storage::directories($directory);
	}

    /**
     * get all folders
     *
     * @return Array
     */
	public function folderIsExist($current, $newDirectory)
	{
		 $folders = Storage::directories($current);

		 if (in_array($newDirectory, $folders)){
		 	return true;
		 }else{
		 	return false;
		 }
	}

    /**
     * get file info by file Path
     *
     * @return Array
     */
	public function fileInfo($filePath)
	{
		$fileName = explode('/', $filePath);
		return [
			'origin'       => $filePath,
			'name'         => end($fileName),
			'type'         => explode('/', Storage::mimeType($filePath))[0],
			'size'         => $this->fileSize($filePath),
			'url'          => env('API_DOMAIN').Storage::url($filePath),
			'lastModified' => date('Y-m-d H:i:s', Storage::lastModified($filePath))
 		];
	}

	/**
     * get file info by file Path
     *
     * @return Array
     */
	public function folderInfo($folderPath)
	{
		$folderName = explode('/', $folderPath);
		return [
			'origin' => $folderPath,
			'name'   => end($folderName),
			'type'   => 'folder',
			'url'    => Storage::url($folderPath),
 		];
	}

    /**
     * store file
     *
     * @return Array
     */
	public function store($directory, $file)
	{
		$filePath = Storage::putFile($this->tempPath, $file);
		$fileType = Storage::mimeType($filePath);
		if (!in_array($fileType, $this->mimeTypes)){
			$this->delFile($filePath);
			return false;
		}else{
			$this->delFile($filePath);
			return Storage::putFile($directory, $file);
		}
	}

    /**
     * delete file
     *
     * @return Array
     */
	public function delFile($filePath)
	{
		if (Storage::exists($filePath)) {
			return Storage::delete($filePath);
		}else{
			return false;
		}
	}

    /**
     * delete folder
     *
     * @return Array
     */
	public function delFolder($directory)
	{
		if (Storage::exists($directory)) {
			return Storage::deleteDirectory($directory);
		}else{
			return false;
		}
	}
    /**
     * change the format of size
     *
     * @return String
     */
	function fileSize($filePath) { 
		$units = array('B', 'KB', 'MB', 'GB', 'TB'); 

		$size = Storage::size($filePath);
	  	for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024; 

	  	return round($size, 2).$units[$i]; 
	}
}