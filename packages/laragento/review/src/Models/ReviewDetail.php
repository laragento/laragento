<?php

namespace Laragento\Review\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Customer\Models\Customer;

/**
 * Class ReviewDetail
 * @package Laragento\Review\Models
 * @property int detail_id
 * @property int review_id
 * @property int store_id
 * @property string title
 * @property string detail
 * @property string nickname
 * @property mixed customer_id
 */
class ReviewDetail extends Model
{
    protected $table = 'review_detail';
    protected $fillable = [
        'detail_id',
        'review_id',
        'store_id',
        'title',
        'detail',
        'nickname',
        'customer_id',
    ];
    protected $primaryKey = 'detail_id';
    public $incrementing = false;
    public $timestamps = false;

    public function review()
    {
        return $this->hasOne(Review::class, 'review_id', 'review_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'customer_id', 'customer_id');
    }
}