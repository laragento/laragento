<?php

namespace Laragento\Review\Tests\Unit;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Laragento\Catalog\Support\Facades\ProductFacade;
use Laragento\Rating\Managers\RatingManager;
use Laragento\Rating\Repositories\RatingOptionRepository;
use Laragento\Rating\Repositories\RatingRepository;
use Laragento\Review\Repositories\ReviewRepository;
use Laragento\Catalog\Models\Product\Product;
use Laragento\Review\Models\Review;
use Tests\CreatesApplication;

abstract class AbstractRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var ReviewRepository
     */
    protected $reviewRepository;

    /**
     * @var RatingManager
     */
    protected $ratingManager;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var Review
     */
    protected $review;

    /**
     * @var Review
     */
    protected $reviewWithRating;


    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');

        $this->ratingManager = new RatingManager(
            new RatingRepository(
                new RatingOptionRepository()
            )
        );
        $this->reviewRepository = new ReviewRepository(
            $this->ratingManager
        );

        try {
            DB::beginTransaction();
        } catch (\Exception $e) {
            dd($e->getCode().': '.$e->getMessage());
        }

        $this->initializeProduct();
        $this->initializeReview();
        $this->initializeReviewWithRating();
    }

    protected function initializeProduct()
    {
        // TODO use a factory
        $sku = 'some-random-sku-2';

        $this->product = ProductFacade::store(
            [
                'sku' => $sku,
                'type_id' => 'simple',
                'website_id' => 1,
            ]
        );
    }

    protected function initializeReview()
    {
        // TODO use a factory
        $this->review = $this->reviewRepository->store(
            [
                'sku' => $this->product->sku,
                'title' => 'Review title 2',
                'detail' => 'Review detail 2',
                'nickname' => 'Review nickname 2',
            ]
        );
    }

    protected function initializeReviewWithRating()
    {
        // TODO don't use static ratingId
        $ratingId = 1;

        // TODO use a factory
        $this->reviewWithRating = $this->reviewRepository->store(
            [
                'sku' => $this->product->sku,
                'title' => 'Review title '.rand(1,5),
                'detail' => 'Review detail '.rand(1,5),
                'nickname' => 'Review nickname '.rand(1,5),
                'rating' => [
                    'value' => rand(1,5),
                    'rating_id' => $ratingId,
                ],
            ]
        );
    }

    protected function getRandomRatingOption($ratingId)
    {
        $ratingOptionRepository = $this->ratingRepository->getRatingOptionRepository();
        $ratingOptions = $ratingOptionRepository->getByRatingId($ratingId);
        return $ratingOptions->random();
    }

    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}