<?php

namespace Laragento\Rating\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RatingEntity
 *
 * @package Laragento\Rating\Models
 * @property int entity_id
 * @property mixed entity_code
 * @property int $entity_id Entity Id
 * @property string $entity_code Entity Code
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingEntity whereEntityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Rating\Models\RatingEntity whereEntityId($value)
 * @mixin \Eloquent
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