<?php

namespace Laragento\Rating\Repositories;

use Laragento\Rating\Models\RatingOption;

interface RatingOptionRepositoryInterface
{
    /**
     * @param $ratingId
     * @return RatingOption
     */
    public function getByRatingId($ratingId);

    /**
     * @param int $ratingId
     * @param int $optionValue
     * @return RatingOption
     */
    public static function firstByValue($ratingId, $optionValue);

    /**
     * @param int $ratingId
     * @param string $optionCode
     * @return RatingOption
     */
    public static function firstByCode($ratingId, $optionCode);


    /**
     * @param $ratingValue
     * @return int|double
     */
    public static function percent($ratingValue);


    /**
     * @param $ratingOptionData
     * @return mixed
     */
    public function store($ratingOptionData);

    /**
     * @param $ratingId
     * @param $optionCount
     * @return mixed
     */
    public function generateDefault($ratingId,$optionCount);

}