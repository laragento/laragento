<?php

namespace Laragento\Quote\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuoteShippingRate
 * @package Laragento\Quote\Models
 */
class QuoteShippingRate extends Model
{
    protected $table = 'quote_shipping_rate';
    protected $fillable = [
        'rate_id',
        'address_id',
        'carrier',
        'carrier_title',
        'code',
        'method',
        'method_description',
        'price',
        'error_message',
        'method_title',
    ];
    protected $primaryKey = 'rate_id';

    public function address()
    {
        return $this->belongsTo(QuoteAddress::class,'address_id','address_id');
    }
}