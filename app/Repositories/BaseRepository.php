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
        return $this->model->paginate($per_page);
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
        return $this->model->findOrFail($id);
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

}

?>