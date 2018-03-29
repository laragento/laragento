<?php

namespace Laragento\Review\Transformers;

use Laragento\Review\Models\Review;
use Laragento\Review\Models\ReviewDetail;
use League\Fractal;

class ReviewTransformer extends Fractal\TransformerAbstract
{
    /**
     * @param Review $review
     * @return array
     */
    public function transform(Review $review)
    {
        /* @var ReviewDetail $reviewDetail */
        $reviewDetail = $review->details()->first();
        return [
            'review_id' => $review->review_id,
            'entity_id' => $review->entity_id,
            'entity_pk_value' => $review->entity_pk_value,
            'status_id' => $review->status_id,
            'created_at' => $review->created_at,
            'title' => $reviewDetail->title,
            'detail' => $reviewDetail->detail,
            'nickname' => $reviewDetail->nickname,
        ];
    }
}