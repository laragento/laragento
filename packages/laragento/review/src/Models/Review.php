<?php

namespace Laragento\Review\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 * @package Laragento\Review\Models
 * @property int review_id
 * @property int entity_id
 * @property int entity_pk_value
 * @property int status_id
 * @property mixed created_at
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