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
}

?>