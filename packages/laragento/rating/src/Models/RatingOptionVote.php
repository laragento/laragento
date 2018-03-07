<?php

namespace Laragento\Rating\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Customer\Models\Customer;
use Laragento\Review\Models\Review;

/**
 * Class RatingOptionVote
 *
 * @package Laragento\Rating\Models
 * @property int vote_id
 * @property int option_id
 * @property mixed remote_ip
 * @property mixed remote_ip_long
 * @property int customer_id
 * @property int entity_pk_value
 * @property int rating_id
 * @property mixed review_id
 * @property int percent
 * @property mixed value
 * @property int $vote_id Vote id
 * @property int $option_id Vote option id
 * @property string $remote_ip Customer IP
 * @property int $remote_ip_long Customer IP converted to long integer format
 * @property int|null $customer_id Customer Id
 * @property int $entity_pk_value Product id
 * @property int $rating_id Rating id
 * @property int|null $review_id Review id
 * @property int $percent Percent amount
 * @property int $value Vote option value
 * @property-read \Laragento\Customer\Models\Customer|null $customer
 * @property-read \Laragento\Rating\Models\RatingOption $option
 * @property-read \Laragento\Rating\Models\Rating $rating
 * @property-read \Laragento\Review\Models\Review|null $review
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVote whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVote whereEntityPkValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVote whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVote wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVote whereRatingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVote whereRemoteIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVote whereRemoteIpLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVote whereReviewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVote whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVote whereVoteId($value)
 * @mixin \Eloquent
 */
class RatingOptionVote extends Model
{
    protected $table = 'rating_option_vote';
    protected $fillable = [
        'vote_id',
        'option_id',
        'remote_ip',
        'remote_ip_long',
        'customer_id',  // can be 0
        'entity_pk_value',
        'rating_id',
        'review_id',    // can be null
        'percent',
        'value',
    ];
    protected $primaryKey = 'vote_id';
    public $timestamps = false;

    public function option()
    {
        return $this->belongsTo(RatingOption::class, 'option_id');
    }

    public function rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }
}