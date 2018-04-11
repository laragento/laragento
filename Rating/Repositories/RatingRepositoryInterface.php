<?php

namespace Laragento\Rating\Repositories;


use Laragento\Core\Repositories\RepositoryInterface;
use Laragento\Rating\Models\RatingEntity;

interface RatingRepositoryInterface extends RepositoryInterface
{
    /**
     * rating entity codes
     */
    const ENTITY_PRODUCT_CODE = 'product';
    const ENTITY_PRODUCT_REVIEW_CODE = 'product_review';
    const ENTITY_REVIEW_CODE = 'review';

    /**
     * @return mixed
     */
    public function getWithOptions();


    /**
     * @param $ratingData
     */
    public function store($ratingData);


    /**
     * @param $votingData
     * @return mixed
     */
    public function vote($votingData);

    /**
     * @param $ratingOptionVoteId
     * @return mixed
     */
    public function destroyVote($ratingOptionVoteId);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

    /**
     * @param $entityPkValue
     * @return mixed
     */
    public function getByEntityPkValue($entityPkValue);

    /**
     * @param $entityCode
     * @return RatingEntity|Null
     */
    public function getEntityByEntityCode($entityCode);

    /**
     * @return mixed
     */
    public function getRatingOptionRepository();
}