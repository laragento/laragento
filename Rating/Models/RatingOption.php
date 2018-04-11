<?php

namespace Laragento\Rating\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RatingEntity
 *
 * @package Laragento\Rating\Models
 * @property int option_id
 * @property int rating_id
 * @property mixed code
 * @property mixed value
 * @property mixed position
 * @property int $option_id Rating Option Id
 * @property int $rating_id Rating Id
 * @property string $code Rating Option Code
 * @property int $value Rating Option Value
 * @property int $position Ration option position on Storefront
 * @property-read \Laragento\Rating\Models\Rating $rating
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOption whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOption whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOption wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOption whereRatingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingOption whereValue($value)
 * @mixin \Eloquent
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