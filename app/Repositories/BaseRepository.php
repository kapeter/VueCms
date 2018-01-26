<?php

namespace App\Repositories;

trait BaseRepository
{
	/**
     * Get all the records
     *
     * @return array
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Get all the records
     *
     * @return array
     */
    public function paginate($per_page)
    {
        return $this->model->orderby('created_at','dsc')->paginate($per_page);
    }

    /**
     * Store a new record.
     *
     * @param  $data
     * @return User
     */
    public function store($data)
    {
        $this->model->fill($data);

        $this->model->save();

        return $this->model;
    }


    /**
     * update a new record.
     *
     * @param  $data
     * @param  $id
     * @return User
     */
    public function update($id, $data)
    {
        $this->model = $this->getById($id);

        $this->model->fill($data);

        $this->model->save();

        return $this->model;
    }

    /**
     * Get the record
     * 
     * @param  int $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->find($id);
    }
    

    /**
     * Delete the record.
     *
     * @param int $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }


    /**
    *  check the uniqueness of fields
    *
    *  @param  \Illuminate\Http\Request  $request
    */
    public function checkUnique($key, $value, $id = 0)
    {
        $count = $this->model->where($key, $value)->where('id','<>',$id)->count();

        return ($count != 0) ? false : true; 
    }

    public function reqIsFromFront($request)
    {
        return null == $request->header('authorization') ? true : false;
    }

    /**
    *  通过某一字段查询值
    *
    *  @param  $column 字段名
    *  @param  $data 字段值
    * 
    */
   
   public function getByColumn($column, $data)
   {
       return $this->model->where($column, $data)->get();
   }

    /**
     * 数组 转 对象
     *
     * @param array $arr 数组
     * @return object
     */
    public function array_to_object($arr) 
    {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)$this->array_to_object($v);
            }
        }
     
        return (object)$arr;
    }
     
    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    public function object_to_array($obj) 
    {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)$this->object_to_array($v);
            }
        }
     
        return $obj;
    }

}

?>