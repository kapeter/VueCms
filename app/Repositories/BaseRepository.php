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
     * Store a new record.
     *
     * @param  $input
     * @return User
     */
    public function store($data)
    {
        return $this->model->save($data);
    }
}

?>