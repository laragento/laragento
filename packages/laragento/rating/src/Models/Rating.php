<?php

namespace Laragento\Rating\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rating
 * @package Laragento\Rating\Models
 * @property int rating_id
 * @property int entity_id
 * @property mixed rating_code
 * @property int position
 * @property int is_active
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