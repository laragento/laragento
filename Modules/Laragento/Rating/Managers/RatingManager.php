<?php

namespace Laragento\Rating\Managers;

use Laragento\Rating\Repositories\RatingRepositoryInterface;

/**
 * Class RatingManager
 * @package Laragento\Rating\Managers
 */
class RatingManager implements RatingManagerInterface
{
    /**
     * @var RatingRepositoryInterface
     */
    protected $ratingRepository;

    /**
     * RatingApi constructor.
     * @param RatingRepositoryInterface $ratingRepository
     */
    public function __construct(
        RatingRepositoryInterface $ratingRepository
    ) {
        $this->ratingRepository = $ratingRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function getWithOptions()
    {
        $this->ratingRepository->getWithOptions();
    }

    /**
     * {@inheritDoc}
     */
    public function store($ratingData)
    {
        $this->ratingRepository->store($ratingData);
    }

    /**
     * {@inheritDoc}
     */
    public function vote($votingData)
    {
        $this->ratingRepository->vote($votingData);
    }

    /**
     * {@inheritDoc}
     */
    public function destroyVote($ratingOptionVoteId)
    {
        $this->ratingRepository->destroyVote($ratingOptionVoteId);
    }

    /**
     * {@inheritDoc}
     */
    public function destroy($id)
    {
        $this->ratingRepository->destroy($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getByEntityPkValue($entityPkValue)
    {
        $this->ratingRepository->getByEntityPkValue($entityPkValue);
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityByEntityCode($entityCode)
    {
        $this->ratingRepository->getEntityByEntityCode($entityCode);
    }

    /**
     * {@inheritDoc}
     */
    public function getRatingOptionRepository()
    {
        $this->ratingRepository->getRatingOptionRepository();
    }

    /**
     * {@inheritDoc}
     */
    public function first($identifier)
    {
        $this->ratingRepository->first($identifier);
    }

    /**
     * {@inheritDoc}
     */
    public function forceFirst($identifier)
    {
        $this->ratingRepository->forceFirst($identifier);
    }

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        $this->ratingRepository->get();
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        $this->ratingRepository->all();
    }

    /**
     * {@inheritDoc}
     */
    public function find()
    {
        $this->ratingRepository->find();
    }
}