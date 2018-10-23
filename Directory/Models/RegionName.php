<?php

namespace Laragento\Directory\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Core\Traits\CompositePrimaryKeys;

/**
 * Class RegionName
 * @package Laragento\Directory\Models
 * @property string locale
 * @property int region_id
 * @property string name
 */
class RegionName extends Model
{
    use CompositePrimaryKeys;

    protected $table = 'directory_country_region_name';
    protected $fillable = [
        'locale',
        'region_id',
        'name',
    ];
    protected $primaryKey = ['locale','region_id'];
}