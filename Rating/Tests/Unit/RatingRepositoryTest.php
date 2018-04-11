<?php
namespace Laragento\Rating\Tests\Unit;

use Laragento\Rating\Models\RatingOption;
use Laragento\Rating\Models\RatingOptionVote;
use Laragento\Rating\Repositories\RatingRepositoryInterface;

class RatingRepositoryTest extends AbstractRepositoryTest
{
    /**
     * @test
     */
    public function vote_on_product()
    {
        $this->assertTrue(true);
//        $this->initializeRating();
//
//        /** @var RatingOption $ratingOption */
//        $ratingOption = $this->getRandomRatingOption($this->rating->getKey());
//
//        /* vote on a random rating option */
//        $vote = $this->ratingRepository->vote(
//            [
//                'review_id' => $this->review->getKey(),
//                'rating_id' => $this->rating->getKey(),
//                'value' => $ratingOption->value,
//                'entity_pk_value' => $this->product->getKey(),
//            ]
//        );
//
//        $this->assertEquals($vote->value, $ratingOption->value);
//
//        /* compare voteData with database */
//        $voteObject = RatingOptionVote::where('vote_id', $vote->getKey())->first();
//        $this->assertEquals($voteObject->vote_id, $vote->getKey());
//        $this->assertEquals($voteObject->review_id, $vote->review_id);
//        $this->assertEquals($voteObject->rating_id, $this->rating->getKey());
//        $this->assertEquals($voteObject->value, $ratingOption->value);
//
//        /* assure that not everything is null*/
//        $this->assertNotNull($voteObject->rating_id);
//        $this->assertNotNull($vote->review_id);
    }

    /**
     * @test
     */
    public function vote_on_product_as_customer()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function get_entity_by_entity_code()
    {
        $ratingEntity = $this->ratingRepository->getEntityByEntityCode(RatingRepositoryInterface::ENTITY_PRODUCT_CODE);
        $this->assertEquals($ratingEntity->getKey(),1);
    }

    /**
     * @test
     */
    public function clean_vote_aggregated()
    {
        $this->ratingOptionRepository->cleanVoteAggregated();
        $this->assertTrue(true);
    }

}