<?php

namespace Laragento\Rating\Http\Api;

/**
 * Interface RatingApiInterface
 * @package Laragento\Rating\Http\Api
 */
interface RatingApiInterface
{
    /**
     * @param $entityId
     * @return string
     */
    public function getByEntityPkValue($entityId);

    /**
     * @param $ratingId
     * @return string
     */
    public function first($ratingId);

    /**
     * @return string
     */
    public function get();
}