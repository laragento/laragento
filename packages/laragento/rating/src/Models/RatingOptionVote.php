<?php

namespace Laragento\Rating\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Customer\Models\Customer;
use Laragento\Review\Models\Review;

/**
 * Class RatingOptionVote
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