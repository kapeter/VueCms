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
}

?>