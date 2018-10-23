<?php

namespace Laragento\Rating\Tests\Unit;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Laragento\Catalog\Support\Facades\ProductFacade;
use Laragento\Rating\Repositories\RatingRepository;
use Laragento\Rating\Repositories\RatingRepositoryInterface;
use Laragento\Review\Repositories\ReviewRepository;
use Laragento\Rating\Repositories\RatingOptionRepository;
use Tests\CreatesApplication;

abstract class AbstractRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var RatingRepository
     */
    protected $ratingRepository;

    /**
     * @var RatingOptionRepository
     */
    protected $ratingOptionRepository;

    /**
     * @var ReviewRepository
     */
    protected $reviewRepository;

    /**
     * @var \Laragento\Catalog\Models\Product\Product
     */
    protected $product;

    /**
     * @var \Laragento\Review\Models\Review
     */
    protected $review;

    /**
     * @var \Laragento\Rating\Models\Rating
     */
    protected $rating;

    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../database/factories');

        $this->ratingOptionRepository = new RatingOptionRepository();
        $this->ratingRepository = new RatingRepository(
            $this->ratingOptionRepository
        );

        /* @todo ATTENTION Circular dependence between review and rating packages*/
        /* @todo replace with manager */
        //$this->reviewRepository = new ReviewRepository($this->ratingRepository);

        try {
            DB::beginTransaction();
        } catch (\Exception $e) {
            dd($e->getCode() . ': ' . $e->getMessage());
        }

        $this->initializeProduct();
        $this->initializeReview();
    }

    protected function initializeProduct()
    {
        // TODO use a factory
        $sku = 'some-random-sku';

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
//        $this->review = $this->reviewRepository->store(
//            [
//                'sku' => $this->product->sku,
//                'title' => 'Review title',
//                'detail' => 'Review detail',
//                'nickname' => 'Review nickname',
//            ]
//        );
    }

    protected function initializeRating($ratingEntityCode = false)
    {
        if (!$ratingEntityCode) {
            $ratingEntity = $this->ratingRepository->getEntityByEntityCode(RatingRepositoryInterface::ENTITY_PRODUCT_CODE);
        } else {
            $ratingEntity = $this->ratingRepository->getEntityByEntityCode($ratingEntityCode);
        }
        $ratingEntityId = $ratingEntity->getKey();

        // TODO use a factory
        $this->rating = $this->ratingRepository->store(
            [
                'entity_id' => $ratingEntityId,
                'rating_code' => 'a_random_rating_code',
                'position' => 0,
                'is_active' => 1,
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