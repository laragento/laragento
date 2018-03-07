<?php

namespace Laragento\Directory\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CountryFormat
 *
 * @package Laragento\Directory\Models
 * @property int country_format_id
 * @property string country_id
 * @property string type
 * @property string format
 * @property int $country_format_id Country Format Id
 * @property string|null $country_id Country Id in ISO-2
 * @property string|null $type Country Format Type
 * @property string $format Country Format
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Directory\Models\CountryFormat whereCountryFormatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Directory\Models\CountryFormat whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Directory\Models\CountryFormat whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Directory\Models\CountryFormat whereType($value)
 * @mixin \Eloquent
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