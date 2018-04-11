<?php

namespace Laragento\Rating\Transformers;

use League\Fractal;

class RatingOptionTransformer extends Fractal\TransformerAbstract
{
    public function transform($ratingOption)
    {
        return [
            'id' => (int)$ratingOption->vote_id,
            'option_id' => (int)$ratingOption->option_id,
            'rating_id' => (int)$ratingOption->rating_id,
            'code' => (string)$ratingOption->code,
            'value' => $ratingOption->value,
            'position' => (int)$ratingOption->position,
        ];
    }
}