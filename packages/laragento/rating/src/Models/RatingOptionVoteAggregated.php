<?php

namespace Laragento\Rating\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RatingOptionVoteAggregated
 * @package Laragento\Rating\Models
 * @property int primary_id
 * @property int rating_id
 * @property int entity_pk_value
 * @property int vote_count
 * @property int vote_value_sum
 * @property int percent
 * @property int percent_approved
 * @property int store_id
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