<?php
namespace Laragento\Core\Http\Api;

interface ApiInterface
{
    /**
     * @param $identifier
     * @return mixed
     */
    public function first($identifier);

    /**
     * @param $identifier
     * @return mixed
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