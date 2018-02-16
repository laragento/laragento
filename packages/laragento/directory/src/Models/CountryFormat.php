<?php

namespace Laragento\Directory\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CountryFormat
 * @package Laragento\Directory\Models
 * @property int country_format_id
 * @property string country_id
 * @property string type
 * @property string format
 */
class CountryFormat extends Model
{
    protected $table = 'directory_country_format';
    protected $fillable = [
        'country_format_id',
        'country_id',
        'type',
        'format',
    ];
    protected $primaryKey = 'country_format_id';
}