<?php

namespace Laragento\Rating\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RatingEntity
 * @package Laragento\Rating\Models
 * @property int entity_id
 * @property mixed entity_code
 */
class RatingEntity extends Model
{
    protected $table = 'rating_entity';
    protected $fillable = [
        'entity_id',
        'entity_code',
    ];
    protected $primaryKey = 'entity_id';
    public $timestamps = false;


}