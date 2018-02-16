<?php

namespace Laragento\Review\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Core\Traits\CompositePrimaryKeys;

/**
 * Class ReviewStore
 * @package Laragento\Review\Models
 * @property int review_id
 * @property int store_id
 */
class ReviewStore extends Model
{
    use CompositePrimaryKeys;

    protected $table = 'review_store';
    protected $fillable = [
        'review_id',
        'store_id',
    ];
    protected $primaryKey = ['review_id', 'store_id'];
    public $incrementing = false;
    public $timestamps = false;

}