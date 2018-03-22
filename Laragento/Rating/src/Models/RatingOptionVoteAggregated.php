<?php

namespace Laragento\Rating\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RatingOptionVoteAggregated
 *
 * @package Laragento\Rating\Models
 * @property int primary_id
 * @property int rating_id
 * @property int entity_pk_value
 * @property int vote_count
 * @property int vote_value_sum
 * @property int percent
 * @property int percent_approved
 * @property int store_id
 * @property int $primary_id Vote aggregation id
 * @property int $rating_id Rating id
 * @property int $entity_pk_value Product id
 * @property int $vote_count Vote dty
 * @property int $vote_value_sum General vote sum
 * @property int $percent Vote percent
 * @property int|null $percent_approved Vote percent approved by admin
 * @property int $store_id Store Id
 * @property-read \Laragento\Rating\Models\Rating $rating
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVoteAggregated whereEntityPkValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVoteAggregated wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVoteAggregated wherePercentApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVoteAggregated wherePrimaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVoteAggregated whereRatingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVoteAggregated whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVoteAggregated whereVoteCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOptionVoteAggregated whereVoteValueSum($value)
 * @mixin \Eloquent
 */
class RatingOptionVoteAggregated extends Model
{
    protected $table = 'rating_option_vote_aggregated';
    protected $fillable = [
        'primary_id',
        'rating_id',
        'entity_pk_value',
        'vote_count',
        'vote_value_sum',
        'percent',
        'percent_approved',
        'store_id',
    ];
    protected $primaryKey = 'primary_id';
    public $timestamps = false;

    public function rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id', 'rating_id');
    }
}