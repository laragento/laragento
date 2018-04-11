<?php

namespace Laragento\Review\Managers;

use Laragento\Review\Repositories\ReviewRepositoryInterface;

/**
 * Class ReviewManager
 * @package Laragento\Review\Managers
 */
class ReviewManager implements ReviewManagerInterface
{
    /**
     * @var ReviewRepositoryInterface
     */
    protected $reviewRepository;

    /**
     * ReviewManager constructor.
     * @param ReviewRepositoryInterface $reviewRepository
     */
    public function __construct(
        ReviewRepositoryInterface $reviewRepository
    ) {
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function firstByEntity(
        $entityPkValue,
        $reviewEntityId = ReviewRepositoryInterface::REVIEW_ENTITY_ID_PRODUCT
    ) {
        return $this->reviewRepository->firstByEntity($entityPkValue, $reviewEntityId);
    }

    /**
     * {@inheritDoc}
     */
    public function getByEntity(
        $entityPkValue,
        $reviewEntityId = ReviewRepositoryInterface::REVIEW_ENTITY_ID_PRODUCT
    ) {
        return $this->reviewRepository->getByEntity($entityPkValue, $reviewEntityId);
    }

    /**
     * {@inheritDoc}
     */
    public function allByEntity(
        $entityPkValue,
        $reviewEntityId = ReviewRepositoryInterface::REVIEW_ENTITY_ID_PRODUCT
    ) {
        return $this->reviewRepository->allByEntity($entityPkValue, $reviewEntityId);
    }

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return $this->reviewRepository->get();
    }

    /**
     * {@inheritDoc}
     */
    public function first($identifier)
    {
        // TODO: Implement first() method.
    }

    /**
     * {@inheritDoc}
     */
    public function forceFirst($identifier)
    {
        // TODO: Implement forceFirst() method.
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * {@inheritDoc}
     */
    public function find()
    {
        // TODO: Implement find() method.
    }

    /**
     * {@inheritDoc}
     */
    public function store($reviewData)
    {
        // TODO: Implement store() method.
    }

    /**
     * {@inheritDoc}
     */
    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    /**
     * {@inheritDoc}
     */
    public function import($reviewData)
    {
        // TODO: Implement import() method.
    }

    /**
     * {@inheritDoc}
     */
    public function configure($config)
    {
        // TODO: Implement configure() method.
    }

    /**
     * {@inheritDoc}
     */
    public function refreshReviewSummary($productId, $reviewId, $stores)
    {
        // TODO: Implement refreshReviewSummary() method.
    }

    /**
     * {@inheritDoc}
     */
    public function deleteReviewsByProductId($productId)
    {
        // TODO: Implement deleteReviewsByProductId() method.
    }

    /**
     * {@inheritDoc}
     */
    public function isApproved()
    {
        // TODO: Implement isApproved() method.
    }
}