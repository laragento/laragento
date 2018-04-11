<?php

namespace Laragento\Directory\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 *
 * @package Laragento\Directory\Models
 * @property string country_id
 * @property string iso2_code
 * @property string iso3_code
 * @property int $country_id Country Id in ISO-2
 * @property string|null $iso2_code Country ISO-2 format
 * @property string|null $iso3_code Country ISO-3
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Directory\Models\Country whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Directory\Models\Country whereIso2Code($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Directory\Models\Country whereIso3Code($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    protected $table = 'directory_country';
    protected $fillable = [
        'country_id',
        'iso2_code',
        'iso3_code'
    ];
    protected $primaryKey = 'country_id';
}