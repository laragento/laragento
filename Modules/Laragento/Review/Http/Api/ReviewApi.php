<?php

namespace Laragento\Review\Http\Api;

use Laragento\Review\Managers\ReviewManagerInterface;
use Laragento\Review\Transformers\ReviewTransformer;
use Spatie\Fractalistic\Fractal;

/**
 * Class ReviewApi
 * @package Laragento\Review\Models
 */
class ReviewApi
{
    /**
     * @var ReviewManagerInterface
     */
    protected $reviewManager;

    /**
     * ReviewApi constructor.
     * @param ReviewManagerInterface $reviewManager
     */
    public function __construct(
        ReviewManagerInterface $reviewManager
    ) {
        $this->reviewManager = $reviewManager;
    }

    /**
     * @param $entityPkValue
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByEntity($entityPkValue)
    {
        return response()->json(Fractal::create(
            $this->reviewManager->getByEntity($entityPkValue),
            new ReviewTransformer()
        ), 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get()
    {
        return response()->json(Fractal::create(
            $this->reviewManager->get(),
            new ReviewTransformer()
        ), 200);
    }
}