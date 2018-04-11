<?php

namespace Laragento\Review\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Customer\Models\Customer;

/**
 * Class ReviewDetail
 *
 * @package Laragento\Review\Models
 * @property int detail_id
 * @property int review_id
 * @property int store_id
 * @property string title
 * @property string detail
 * @property string nickname
 * @property mixed customer_id
 * @property int $detail_id Review detail id
 * @property int $review_id Review id
 * @property int|null $store_id Store id
 * @property string $title Title
 * @property string $detail Detail description
 * @property string $nickname User nickname
 * @property int|null $customer_id Customer Id
 * @property-read \Laragento\Customer\Models\Customer $customer
 * @property-read \Laragento\Review\Models\Review $review
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewDetail whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewDetail whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewDetail whereDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewDetail whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewDetail whereReviewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewDetail whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewDetail whereTitle($value)
 * @mixin \Eloquent
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