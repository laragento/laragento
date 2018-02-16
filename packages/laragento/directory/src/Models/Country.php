<?php

namespace Laragento\Directory\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * @package Laragento\Directory\Models
 * @property string country_id
 * @property string iso2_code
 * @property string iso3_code
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