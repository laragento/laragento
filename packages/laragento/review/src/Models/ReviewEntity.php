<?php

namespace Laragento\Review\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReviewEntity
 * @package Laragento\Review\Models
 * @property int entity_id
 * @property string entity_code
 */
class ReviewEntity extends Model
{
    protected $table = 'review_entity';
    protected $fillable = [
        'entity_id',
        'entity_code',
    ];
    protected $primaryKey = 'entity_id';
    public $incrementing = false;
}