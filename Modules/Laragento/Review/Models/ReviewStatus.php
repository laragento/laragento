<?php

namespace Laragento\Review\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReviewStatus
 *
 * @package Laragento\Review\Models
 * @property int status_id
 * @property string status_code
 * @property int $status_id Status id
 * @property string $status_code Status code
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewStatus whereStatusCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Review\Models\ReviewStatus whereStatusId($value)
 * @mixin \Eloquent
 */
class ReviewStatus extends Model
{
    protected $table = 'review_status';
    protected $fillable = [
        'status_id',
        'status_code',
    ];
    protected $primaryKey = 'status_id';
    public $incrementing = false;
}