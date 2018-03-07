<?php

namespace Laragento\Rating\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rating
 *
 * @package Laragento\Rating\Models
 * @property int rating_id
 * @property int entity_id
 * @property mixed rating_code
 * @property int position
 * @property int is_active
 * @property int $rating_id Rating Id
 * @property int $entity_id Entity Id
 * @property string $rating_code Rating Code
 * @property int $position Rating Position On Storefront
 * @property int $is_active Rating is active.
 * @property-read \Laragento\Rating\Models\RatingEntity $entity
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Rating\Models\RatingOption[] $options
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Rating\Models\RatingOptionVote[] $votes
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\Rating whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\Rating whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\Rating wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\Rating whereRatingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\Rating whereRatingId($value)
 * @mixin \Eloquent
 */
class Rating extends Model
{
    protected $table = 'rating';
    protected $fillable = [
        'rating_id',
        'entity_id',
        'rating_code',
        'position',
        'is_active',
    ];
    protected $primaryKey = 'rating_id';
    public $timestamps = false;

    public function entity()
    {
        return $this->belongsTo(RatingEntity::class,'entity_id','entity_id');
    }

    public function options()
    {
        return $this->hasMany(RatingOption::class,'rating_id','rating_id');
    }

    public function votes()
    {
        return $this->hasMany(RatingOptionVote::class,'rating_id','rating_id');
    }
}