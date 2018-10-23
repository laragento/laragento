<?php

namespace Laragento\Rating\Repositories;

use Illuminate\Support\Facades\Request;
use Laragento\Rating\Models\Rating;
use Laragento\Rating\Models\RatingEntity;
use Laragento\Rating\Models\RatingOptionVote;

/**
 * Class RatingRepository
 * @package Laragento\Rating\Repositories
 */
class RatingRepository implements RatingRepositoryInterface
{
    /**
     * @var RatingOptionRepositoryInterface
     */
    protected $ratingOptionRepository;

    /**
     * RatingRepository constructor.
     * @param RatingOptionRepositoryInterface $ratingOptionRepository
     */
    public function __construct(RatingOptionRepositoryInterface $ratingOptionRepository)
    {
        $this->ratingOptionRepository = $ratingOptionRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function first($ratingId)
    {
        return Rating::where('is_active', 1)
            ->where('rating_id', $ratingId)
            ->orderBy('position')
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function forceFirst($ratingId)
    {
        return Rating::where('rating_id', $ratingId)
            ->orderBy('position')
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getWithOptions()
    {
        return Rating::with('options')
            ->where('is_active', 1)
            ->orderBy('position')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return Rating::with('votes')
            ->where('is_active', 1)
            ->orderBy('position')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return Rating::with('votes')
            ->orderBy('position')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getByEntityPkValue($entityPkValue)
    {
        return Rating::with([
            'votes' => function ($query) use ($entityPkValue) {
                $query->where('entity_pk_value', $entityPkValue);
                $query->orderByDesc('vote_id');
            }
        ])
            ->where('is_active', 1)
            ->orderBy('position')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function store($ratingData)
    {
        $rating = false;
        if (isset($ratingData['rating_id'])) {
            $rating = Rating::where(['rating_id' => $ratingData['rating_id']])->first();
        }

        if (!$rating) {
            $rating = new Rating($ratingData);
            $rating->save();

            $this->ratingOptionRepository->generateDefault($rating->getKey(),5);
        } else {
            $rating->update($ratingData);
        }
        return $rating;
    }

    /**
     * {@inheritDoc}
     */
    public function vote($votingData)
    {
        // @todo check if the value is an integer
        $vote = new RatingOptionVote();

        if (isset($votingData['customer_id'])) {
            $vote->customer_id = $votingData['customer_id'];
        }

        if (isset($votingData['review_id'])) {
            $vote->review_id = $votingData['review_id'];
        }

        if (isset($votingData['entity_pk_value'])) {
            $vote->entity_pk_value = $votingData['entity_pk_value'];
        }

        if (!isset($votingData['value']) || !isset($votingData['rating_id'])) {
            return false;
        }

        $ratingOption = $this->ratingOptionRepository::firstByValue($votingData['rating_id'], $votingData['value']);

        $vote->option_id = $ratingOption->option_id;
        $vote->remote_ip = Request::ip();
        $vote->remote_ip_long = ip2long(Request::ip());

        $vote->rating_id = $votingData['rating_id'];
        $vote->percent = $this->ratingOptionRepository::percent($votingData['value']);

        $vote->value = $votingData['value'];
        $vote->save();

        return $vote;
    }

    /**
     * {@inheritDoc}
     */
    public function destroyVote($ratingOptionVoteId)
    {
        // TODO: Implement destroyVote() method.
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
    public function find()
    {
        // TODO: Implement find() method.
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityByEntityCode($entityCode)
    {
        return RatingEntity::whereEntityCode($entityCode)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getRatingOptionRepository()
    {
        return $this->ratingOptionRepository;
    }
}