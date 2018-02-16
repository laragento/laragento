<?php

namespace Laragento\Rating\Transformers;

use League\Fractal;

class RatingOptionVoteTransformer extends Fractal\TransformerAbstract
{
    public function transform($rating)
    {
        return [
            'id' => (int)$rating->vote_id,
            'option_id' => (int)$rating->option_id,
            'entity_pk_value' => (int)$rating->entity_pk_value,
            'rating_id' => $rating->rating_id,
            'review_id' => $rating->review_id,
            'percent' => $rating->percent,
            'value' => $rating->value,
        ];
    }
}