<?php

namespace Laragento\Directory\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Core\Traits\CompositePrimaryKeys;

/**
 * Class CurrencyRate
 * @package Laragento\Directory\Models
 * @property string currency_from
 * @property string currency_to
 * @property mixed rate
 */
class CurrencyRate extends Model
{
    use CompositePrimaryKeys;

    protected $table = 'directory_currency_rate';
    protected $fillable = [
        'currency_from',
        'currency_to',
        'rate',
    ];
    protected $primaryKey = ['currency_from','currency_to'];
}