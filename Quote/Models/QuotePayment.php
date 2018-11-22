<?php

namespace Laragento\Quote\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuotePayment
 * @package Laragento\Quote\Models
 */
class QuotePayment extends Model
{
    protected $table = 'quote_payment';
    protected $fillable = [
        'payment_id',
        'quote_id',
        'method',
        'cc_type',
        'cc_number_enc',
        'cc_last_4',
        'cc_cid_enc',
        'cc_owner',
        'cc_exp_year',
        'cc_exp_month',
        'cc_ss_owner',
        'cc_ss_start_month',
        'cc_sss_start_year',
        'po_number',
        'additional_data',
        'cc_ss_issue',
        'additional_information',
        'paypal_payer_id',
        'paypal_payer_status',
        'paypal_correlation_id',
    ];
    protected $primaryKey = 'payment_id';

    public function quote()
    {
        return $this->belongsTo(Quote::class,'quote_id','quote_id');
    }
}