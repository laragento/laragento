<?php

namespace Laragento\Core\Repositories;


use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * @param $identifier
     * @return Model|Null
     */
    public function first($identifier);

    /**
     * @param $identifier
     * @return Model|Null
     */
    public function forceFirst($identifier);

    /**
     * @return mixed
     */
    public function get();

    /**
     * @return mixed
     */
    public function all();

    /**
     * @return mixed
     */
    public function find();
}