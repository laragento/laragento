<?php

namespace Laragento\Rating\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Core\Traits\CompositePrimaryKeys;
use Laragento\Store\Models\Store;

/**
 * Class RatingTitle
 * @package Laragento\Rating\Models
 * @property int rating_id
 * @property int store_id
 * @property mixed value
 */
class RatingTitle extends Model
{
    use CompositePrimaryKeys;

    protected $table = 'rating_title';
    protected $fillable = [
        'rating_id',
        'store_id',
        'value',
    ];
    protected $primaryKey = [
        'rating_id',
        'store_id',
    ];
    public $timestamps = false;


    public function rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id', 'rating_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'store_id');
    }
}