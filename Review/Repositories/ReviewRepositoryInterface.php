<?php

namespace Laragento\Review\Repositories;

use Laragento\Core\Repositories\RepositoryInterface;

interface ReviewRepositoryInterface extends RepositoryInterface
{
    const REVIEW_ENTITY_ID_PRODUCT = 1;
    const REVIEW_STATUS_ID_APPROVED = 1;
    const REVIEW_STATUS_ID_PENDING = 2;
    const REVIEW_STATUS_ID_NOT_APPROVED = 3;

    /**
     * Create a review with review-details, $reviewData can be passed as an array
     *
     * @param $reviewData
     */
    public function store($reviewData);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);


    /**
     * @param $entityPkValue
     * @param int $entityId
     * @return mixed
     */
    public function firstByEntity($entityPkValue, $entityId = ReviewRepositoryInterface::REVIEW_ENTITY_ID_PRODUCT);

    /**
     * @param $entityPkValue
     * @param int $entityId
     * @return mixed
     */
    public function getByEntity($entityPkValue, $entityId = ReviewRepositoryInterface::REVIEW_ENTITY_ID_PRODUCT);

    /**
     * @param $entityPkValue
     * @param int $entityId
     * @return mixed
     */
    public function allByEntity($entityPkValue, $entityId = ReviewRepositoryInterface::REVIEW_ENTITY_ID_PRODUCT);


    /**
     * @param $reviewData
     * @return mixed
     */
    public function import($reviewData);

    /**
     * @param $config
     * @return mixed
     */
    public function configure($config);

    /**
     * @param $productId
     * @param $reviewId
     * @param $stores
     * @return mixed
     */
    public function refreshReviewSummary($productId, $reviewId, $stores);


    /**
     * Delete reviews by product id.
     * Better to call this method in transaction, because operation performed on two separated tables
     *
     * @param int $productId
     * @return $this
     */
    public function deleteReviewsByProductId($productId);


    /**
     * Check if current review approved or not
     *
     * @return bool
     */
    public function isApproved();


}