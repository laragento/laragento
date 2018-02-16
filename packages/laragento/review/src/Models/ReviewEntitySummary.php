<?php

namespace Laragento\Review\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReviewEntitySummary
 * @package Laragento\Review\Models
 * @property int primary_id
 * @property int entity_pk_value
 * @property mixed entity_type
 * @property int reviews_count
 * @property int rating_summary
 * @property int store_id
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