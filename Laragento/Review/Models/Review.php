<?php

namespace Laragento\Review\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 *
 * @package Laragento\Review\Models
 * @property int review_id
 * @property int entity_id
 * @property int entity_pk_value
 * @property int status_id
 * @property mixed created_at
 * @property int $review_id Review id
 * @property string $created_at Review create date
 * @property int $entity_id Entity id
 * @property int $entity_pk_value Product id
 * @property int $status_id Status code
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Review\Models\ReviewDetail[] $details
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\Review whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\Review whereEntityPkValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\Review whereReviewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\Review whereStatusId($value)
 * @mixin \Eloquent
 */
class Review extends Model
{
    protected $table = 'review';
    protected $fillable = [
        'review_id',
        'entity_id',
        'entity_pk_value',
        'status_id',
        'created_at',
    ];
    protected $primaryKey = 'review_id';
    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(ReviewDetail::class, 'review_id', 'review_id');
    }

}