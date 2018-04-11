<?php

namespace Laragento\Directory\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Region
 *
 * @package Laragento\Directory\Models
 * @property int region_id
 * @property string country_id
 * @property string code
 * @property string default_name
 * @property int $region_id Region Id
 * @property string $country_id Country Id in ISO-2
 * @property string|null $code Region code
 * @property string|null $default_name Region Name
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Directory\Models\Region whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Directory\Models\Region whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Directory\Models\Region whereDefaultName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Directory\Models\Region whereRegionId($value)
 * @mixin \Eloquent
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