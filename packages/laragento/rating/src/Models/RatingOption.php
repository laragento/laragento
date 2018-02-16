<?php

namespace Laragento\Rating\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RatingEntity
 * @package Laragento\Rating\Models
 * @property int option_id
 * @property int rating_id
 * @property mixed code
 * @property mixed value
 * @property mixed position
 */
class RatingOption extends Model
{
    protected $table = 'rating_option';
    protected $fillable = [
        'option_id',
        'rating_id',
        'code',
        'value',
        'position',
    ];
    protected $primaryKey = 'option_id';
    public $timestamps = false;

    public function rating()
    {
        return $this->belongsTo(Rating::class,'rating_id');
    }
}