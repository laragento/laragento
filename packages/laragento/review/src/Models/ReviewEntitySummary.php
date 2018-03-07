<?php

namespace Laragento\Review\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReviewEntitySummary
 *
 * @package Laragento\Review\Models
 * @property int primary_id
 * @property int entity_pk_value
 * @property mixed entity_type
 * @property int reviews_count
 * @property int rating_summary
 * @property int store_id
 * @property int $primary_id Summary review entity id
 * @property int $entity_pk_value Product id
 * @property int $entity_type Entity type id
 * @property int $reviews_count Qty of reviews
 * @property int $rating_summary Summarized rating
 * @property int $store_id Store id
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewEntitySummary whereEntityPkValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewEntitySummary whereEntityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewEntitySummary wherePrimaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewEntitySummary whereRatingSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewEntitySummary whereReviewsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewEntitySummary whereStoreId($value)
 * @mixin \Eloquent
 */
class ReviewEntitySummary extends Model
{
    protected $table = 'review_entity_summary';
    protected $fillable = [
        'primary_id',
        'entity_pk_value',
        'entity_type',
        'reviews_count',
        'rating_summary',
        'store_id',
    ];
    protected $primaryKey = 'primary_id';
    public $timestamps = false;
}