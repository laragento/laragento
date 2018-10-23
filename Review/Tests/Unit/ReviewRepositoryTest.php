<?php

namespace Laragento\Review\Tests\Unit;

use Laragento\Rating\Models\RatingOptionVote;
use Laragento\Review\Models\Review;
use Laragento\Review\Models\ReviewDetail;
use Laragento\Review\Support\Facades\ReviewFacade;

class ReviewRepositoryTest extends AbstractRepositoryTest
{
    /**
     * @test
     */
    public function create_new_review_for_product()
    {
        $this->assertNotNull($this->review->entity_pk_value);
        $this->assertEquals($this->review->entity_pk_value, $this->product->getKey());
    }

    /**
     * @test
     */
    public function create_new_review_for_product_with_rating()
    {
        /* Check Review */
        $this->assertNotNull($this->reviewWithRating->entity_pk_value);
        $this->assertEquals($this->reviewWithRating->entity_pk_value, $this->product->getKey());

        /* Check Rating */
        $ratingOptionVote = RatingOptionVote::with('rating')
            ->where('review_id', $this->reviewWithRating->getKey())->first();
        $this->assertEquals($this->product->getKey(), $ratingOptionVote->entity_pk_value);
    }


    /**
     * @test
     */
    public function test_first_by_entity_tested_with_facade()
    {
        $productPkValue = ReviewFacade::firstByEntity(
            $this->product->getKey()
        )->entity_pk_value;
        $this->assertEquals($this->review->entity_pk_value, $productPkValue);
    }

    /**
     * @test
     */
    public function update_review_details()
    {
        $review = Review::with('details')
            ->where('review_id', $this->review->getKey())
            ->first();

        /* @var ReviewDetail $reviewDetail */
        $reviewDetail = $review->details[0];

        /* @todo implement test */
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function is_review_approved()
    {
        /* @todo implement test */
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function approve_review()
    {
        /* @todo implement test */
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function disapprove_review()
    {
        /* @todo implement test */
        $this->assertTrue(true);
    }
}