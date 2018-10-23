<?php

namespace Laragento\Review\Repositories;

use Illuminate\Support\Carbon;
use Laragento\Catalog\Support\Facades\ProductFacade;
use Laragento\Rating\Managers\RatingManagerInterface;
use Laragento\Review\Models\Review;
use Laragento\Review\Models\ReviewDetail;
use Laragento\Review\Models\ReviewEntitySummary;
use Laragento\Review\Models\ReviewStore;
use Laragento\Store\Repositories\StoreRepository;

class ReviewRepository implements ReviewRepositoryInterface
{
    protected $ratingManager;

    /**
     * ReviewRepository constructor.
     * @param RatingManagerInterface $ratingManager
     */
    public function __construct(RatingManagerInterface $ratingManager)
    {
        $this->ratingManager = $ratingManager;
    }

    /**
     * {@inheritdoc}
     */
    public function first($reviewId)
    {
        return Review::with('details')
            ->where('review_id', $reviewId)
            ->where('status_id', ReviewRepositoryInterface::REVIEW_STATUS_ID_APPROVED)
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function forceFirst($reviewId)
    {
        return Review::with('details')
            ->where('review_id', $reviewId)
            ->first();
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return Review::with('details')
            ->where('status_id', ReviewRepositoryInterface::REVIEW_STATUS_ID_APPROVED)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Review::with('details')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find()
    {
        // TODO: Implement find() method in ReviewRepository.
    }

    /**
     * {@inheritdoc}
     */
    public function store($reviewData)
    {
        if (!isset($reviewData['status'])) {
            $status = ReviewRepositoryInterface::REVIEW_STATUS_ID_APPROVED;
        } else {
            $status = $reviewData['status'];
        }

        $productId = ProductFacade::getIdBySku($reviewData['sku']);
        if (!$productId) {
            print_r($reviewData['sku'] . ' sku for review was not found');
            return false;
        }

        /* Create Review */
        $review = $this->createReview($reviewData, $productId, $status);

        /* Create Review Detail */
        $reviewDetail = $this->createReviewDetail($reviewData, $review);

        /* Create Review Store */
        $stores = $this->createReviewStore($reviewDetail);

        /* Create Comment */
        $reviewData = $this->createReviewComment($reviewData, $status);

        /* Rate On Review */
        $this->rateOnReviews($reviewData, $review, $productId);

        /* Refresh Review Summary */
        $this->refreshReviewSummary($productId, $review->review_id, $stores);

        return $review;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    /**
     * {@inheritdoc}
     */
    public function firstByEntity($entityPkValue, $entityId = ReviewRepositoryInterface::REVIEW_ENTITY_ID_PRODUCT)
    {
        return $this->getByEntity($entityPkValue,$entityId)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getByEntity($entityPkValue, $entityId = ReviewRepositoryInterface::REVIEW_ENTITY_ID_PRODUCT)
    {
         return Review::with('details')
            ->where('entity_pk_value', $entityPkValue)
            ->where('entity_id', $entityId)
            ->where('status_id', ReviewRepositoryInterface::REVIEW_STATUS_ID_APPROVED)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function allByEntity($entityPkValue, $entityId = ReviewRepositoryInterface::REVIEW_ENTITY_ID_PRODUCT)
    {
        return Review::with('details')
            ->where('entity_pk_value', $entityPkValue)
            ->where('entity_id', $entityId)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function import($reviewData)
    {
        foreach ($reviewData['data'] as $data) {
            $this->store($data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configure($config)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function refreshReviewSummary($productId, $reviewId, $stores)
    {
        foreach ($stores as $store) {
            if ($store->store_id == 0) {
                continue;
            }
            $summary = ReviewEntitySummary::firstOrNew([
                'entity_pk_value' => $productId,
                'entity_type' => 1,
                'store_id' => $store->store_id,
            ]);

            $summary->reviews_count = ReviewDetail::where('review_id', $reviewId)
                ->where('store_id', $store->store_id)->count();

            $summary->save();
        }
    }


    /**
     * {@inheritdoc}
     */
    public function deleteReviewsByProductId($productId)
    {
        // TODO: Implement deleteReviewsByProductId() method.
    }

    /**
     * {@inheritdoc}
     */
    public function isApproved()
    {
        // TODO: Implement isApproved() method.
    }

    /**
     * @param $reviewData
     * @param $productId
     * @param $status
     * @return Review
     */
    protected function createReview($reviewData, $productId, $status)
    {
        if (!isset($reviewData['updated_at'])) {
            $reviewUpdatedAt = Carbon::now();
        } else {
            $reviewUpdatedAt = $reviewData['updated_at'];
        }
        $review = new Review();
        $review->entity_id = ReviewRepositoryInterface::REVIEW_ENTITY_ID_PRODUCT;
        $review->entity_pk_value = $productId;
        $review->status_id = $status;
        $review->created_at = $reviewUpdatedAt;

        $review->save(['timestamps' => false]);
        return $review;
    }

    /**
     * @param $reviewData
     * @param $review
     * @return mixed
     */
    public function createReviewDetail($reviewData, $review)
    {
        // @todo store_id is hardcoded
        if (!isset($reviewData['store_id'])) {
            $storeId = 1;
        } else {
            $storeId = $reviewData['store_id'];
        }

        $reviewDetail = ReviewDetail::create([
            'review_id' => $review->review_id,
            'store_id' => $storeId,  // I think this attribute means created in store
            'title' => $reviewData['title'],
            'detail' => $reviewData['detail'],
            'nickname' => $reviewData['nickname'],
        ]);
        return $reviewDetail;
    }

    /**
     * @param $reviewDetail
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public function createReviewStore($reviewDetail)
    {
        // @todo save reviews to stores is not perfect implemented

        $storeRepository = new StoreRepository();
        $stores = $storeRepository->all();

        foreach ($stores as $store) {
            ReviewStore::create([
                'review_id' => $reviewDetail->review_id,
                'store_id' => $store->store_id,
            ]);
        }
        return $stores;
    }

    /**
     * @param $reviewData
     * @param $status
     * @return mixed
     */
    public function createReviewComment($reviewData, $status)
    {
        if (isset($reviewData['store_owner_comment']) && trim($reviewData['store_owner_comment']) != '') {
            $this->store([
                'sku' => $reviewData['sku'],
                'title' => $reviewData['title'],
                'detail' => $reviewData['store_owner_comment'],
                'nickname' => $reviewData['store_owner_nickname'],
                'status_id' => $status,
            ]);
        }
        return $reviewData;
    }

    /**
     * @param $reviewData
     * @param $review
     * @param $productId
     */
    public function rateOnReviews($reviewData, $review, $productId): void
    {
        if (isset($reviewData['rating'])) {
            $rating = $reviewData['rating'];
            $this->ratingManager->vote(
                [
                    'review_id' => $review->getKey(),
                    'rating_id' => $rating['rating_id'],
                    'value' => $rating['value'],
                    'entity_pk_value' => $productId,
                ]
            );
        }
    }


    /**
     * @param $entityId
     * @return mixed
     */
    public function getAllByEntity($entityId)
    {
        // TODO: Implement getAllByEntity() method.
    }
}