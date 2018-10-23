<?php

namespace Laragento\Rating\Repositories;

use Laragento\Rating\Models\RatingOption;
use Laragento\Rating\Models\RatingOptionVote;
use Laragento\Rating\Models\RatingOptionVoteAggregated;
use Laragento\Store\Support\Facades\StoreFacade;


/**
 * Class RatingOptionRepository
 * @package Laragento\Rating\Repositories
 */
class RatingOptionRepository implements RatingOptionRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getByRatingId($ratingId)
    {
        return RatingOption::with([
            'rating' => function ($query) {
                $query->where('is_active', 1);
            }
        ])
            ->where('rating_id', $ratingId)
            ->orderBy('position')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public static function firstByValue($ratingId, $optionValue)
    {
        return RatingOption::where('value', $optionValue)
            ->where('rating_id', $ratingId)
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public static function firstByCode($ratingId, $optionCode)
    {
        return RatingOption::where('code', $optionCode)
            ->where('rating_id', $ratingId)
            ->first();
    }


    /**
     * {@inheritDoc}
     */
    public static function percent($ratingValue)
    {
        // TODO calculate according to the options (there can be a different number of options than 5)
        return ((int)$ratingValue * 20);
    }

    /**
     * {@inheritDoc}
     */
    public function generateDefault($ratingId, $optionCount)
    {
        for ($i = 1; $i <= $optionCount; $i++) {
            $this->store([
                'rating_id' => $ratingId,
                'code' => $i,
                'value' => $i,
                'position' => $i,
            ]);
        }
    }

    public function cleanVoteAggregated(){
        $currentEntityId = false;
        $first = true;
        $currentVotes = [];
        $currentVotesTotal = 0;
        $ratingVotes = RatingOptionVote::orderBy('entity_pk_value')->get();
        $stores = StoreFacade::get();

        foreach ($ratingVotes as $ratingVote){
            $currentVotes[] = $ratingVote->value;
            $currentVotesTotal = $currentVotesTotal + $ratingVote->value;

            if($currentEntityId != $ratingVote->entity_pk_value){
                $currentEntityId = $ratingVote->entity_pk_value;
                if(!$first){

                    foreach ($stores as $store){
                        $voteCount = count($currentVotes);
                        $aggregated = new RatingOptionVoteAggregated(
                            [
                                'rating_id' => $ratingVote->rating_id,
                                'entity_pk_value' => $ratingVote->entity_pk_value,
                                'vote_count' => $voteCount,
                                'vote_value_sum' => array_sum($currentVotes),
                                'percent' => $this->percent(round($currentVotesTotal / $voteCount)),
                                'percent_approved' => 100,
                                'store_id' => $store->getKey(),
                            ]
                        );
                        $aggregated->save();
                    }

                    //print_r('['.$voteValueSum.' > '.$currentEntityId.']');
                    $currentVotes = [];
                    $currentVotesTotal = 0;
                }
            }
            $first = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function store($ratingOptionData)
    {
        // @todo implement update procedure
        $ratingOption = new RatingOption($ratingOptionData);
        $ratingOption->save();
        return $ratingOption;
    }
}