<?php

namespace Laragento\Review\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReviewStatus
 * @package Laragento\Review\Models
 * @property int status_id
 * @property string status_code
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