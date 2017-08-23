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
	protected $rootPath = 'public';

	protected $tempPath = 'temp';

	protected $mimeTypes;  //mime_type array

	public function __construct()
	{
		$this->mimeTypes = explode(',',config('filesystems.mime_type'));
	}

	// make a new folder
	public function make($directory)
	{
		$path = $this->rootPath.'/'.$directory;

		return Storage::makeDirectory($path);
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
	public function folders()
	{
		 $allPath = Storage::allDirectories($this->rootPath);

		 return json_encode($this->format($allPath));
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
			'url'          => Storage::url($filePath),
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
			return Storage::putFile($this->rootPath.$directory, $file);
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

    /**
     * change the format of path array
     *
     * @return Array
     */
	public function format($arr)
	{
		$result = [];
		$temp = [];
		$hand = -1;
		foreach ($arr as $key => $value) {
			$str = str_replace($this->rootPath.'/',"",$value);
			$temp = explode("/", $str);
			$len = sizeof($temp);
			if ($len == 1){
				$hand++;
				$result[$hand]['value'] = $temp[0];
				$result[$hand]['label'] = $temp[0];
				continue;
			}else{
				if (!isset($result[$hand]['children'])){
					$result[$hand]['children'] = [];
				}
				$child = &$result[$hand]['children'];
				foreach ($temp as $sKey => $sValue) {
					if ($sKey == $len - 1){
						array_push($child,['value'=> $sValue,'label'=>$sValue]);
					}else{
						foreach ($child as $tKey => $tValue) {
							if ($tValue['value'] == $sValue){
								if (!isset($child[$tKey]['children'])){
									$child[$tKey]['children'] = [];
								}
								$child = &$child[$tKey]['children'];
								break;
							}
						}
					}
				}
			}
		}
		return $result;
	}
}