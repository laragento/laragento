<?php

namespace Laragento\Directory\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Region
 * @package Laragento\Directory\Models
 * @property int region_id
 * @property string country_id
 * @property string code
 * @property string default_name
 */
class Region extends Model
{
    protected $table = 'directory_country_region';
    protected $fillable = [
        'region_id',
        'country_id',
        'code',
        'default_name'
    ];
    protected $primaryKey = 'region_id';
}