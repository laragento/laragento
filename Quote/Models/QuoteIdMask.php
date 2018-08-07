<?php

namespace Laragento\Quote\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuoteIdMask
 * @package Laragento\Quote\Models
 */
class QuoteIdMask extends Model
{
    protected $table = 'quote';
    protected $fillable = [
        'entity_id',
        'quote_id',
        'masked_id',
    ];
    protected $primaryKey = 'entity_id';
}
