<?php

namespace Laragento\Rating\Transformers;

use Laragento\Rating\Models\Rating;
use League\Fractal;

class RatingTransformer extends Fractal\TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'votes',
        'options',
    ];

    /**
     * @param Rating $rating
     * @return array
     */
    public function transform(Rating $rating)
    {
        return [
            'id' => (int)$rating->rating_id,
            //'entity_id' => (int)$rating->entity_id,   // Rating Entity ID
            'rating_code' => $rating->rating_code,
            'position' => $rating->position,
            'is_active' => $rating->is_active,
        ];
    }

    /**
     * @param $votes
     * @return Fractal\Resource\Collection
     */
    protected function includeVotes($votes)
    {
        return $this->collection($votes->votes, new RatingOptionVoteTransformer());
    }

    /**
     * @param $votes
     * @return Fractal\Resource\Collection
     */
    protected function includeOptions($votes)
    {
        return $this->collection($votes->options, new RatingOptionTransformer());
    }
}