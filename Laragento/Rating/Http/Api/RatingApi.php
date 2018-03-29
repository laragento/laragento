<?php

namespace Laragento\Rating\Http\Api;

use Laragento\Rating\Repositories\RatingOptionRepositoryInterface;
use Laragento\Rating\Repositories\RatingRepositoryInterface;
use Laragento\Rating\Transformers\RatingTransformer;
use Spatie\Fractal\Fractal;

/**
 * Class RatingApi
 * @package Laragento\Rating\Http\Api
 */
class RatingApi implements RatingApiInterface
{
    /**
     * @var RatingRepositoryInterface
     */
    protected $ratingRepository;

    /**
     * @var RatingOptionRepositoryInterface
     */
    protected $ratingOptionRepository;

    /**
     * RatingApi constructor.
     * @param RatingRepositoryInterface $ratingRepository
     * @param RatingOptionRepositoryInterface $ratingOptionRepository
     */
    public function __construct(
        RatingRepositoryInterface $ratingRepository,
        RatingOptionRepositoryInterface $ratingOptionRepository
    ) {
        $this->ratingRepository = $ratingRepository;
        $this->ratingOptionRepository = $ratingOptionRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function getByEntityPkValue($entityId)
    {
        $fractal = Fractal::create(
            $this->ratingRepository->getByEntityPkValue($entityId),
            new RatingTransformer()
        )
            ->parseIncludes('votes');
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function options()
    {
        $fractal = Fractal::create(
            $this->ratingRepository->options(),
            new RatingTransformer()
        )
            ->parseIncludes('options');
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        $fractal = Fractal::create(
            $this->ratingRepository->get(),
            new RatingTransformer()
        )
            ->parseIncludes('votes');
        return response()->json($fractal, 200);
    }

    /**
     * @param $ratingId
     * @return string
     */
    public function first($ratingId)
    {
        $fractal = Fractal::create(
            $this->ratingRepository->first($ratingId),
            new RatingTransformer()
        )
            ->parseIncludes('votes');
        return response()->json($fractal, 200);
    }
}