<?php

namespace Laragento\Sales\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Laragento\Sales\Models\Order;
use Laragento\Store\Models\Store;

/**
 * Sales Order Payment Model
* @property int entity_id
* @property int parent_id
* @property float base_shipping_captured
* @property float shipping_captured
* @property float amount_refunded
* @property float base_amount_paid
* @property float amount_canceled
* @property float base_amount_authorized
* @property float base_amount_paid_online
* @property float base_amount_refunded_online
* @property float base_shipping_amount
* @property float shipping_amount
* @property float amount_paid
* @property float amount_authorized
* @property float base_amount_ordered
* @property float base_shipping_refunded
* @property float shipping_refunded
* @property float base_amount_refunded
* @property float amount_ordered
* @property float base_amount_canceled
* @property int quote_payment_id
* @property mixed additional_data
* @property string cc_exp_month
* @property string cc_ss_start_year
* @property string echeck_bank_name
* @property string method
* @property string cc_debug_request_body
* @property string cc_secure_verify
* @property string protection_eligibility
* @property string cc_approval
* @property string cc_last_4
* @property string cc_status_description
* @property string echeck_type
* @property string cc_debug_response_serialized
* @property string cc_ss_start_month
* @property string echeck_account_type
* @property string last_trans_id
* @property string cc_cid_status
* @property string cc_owner
* @property string cc_type
* @property string po_number
* @property string cc_exp_year
* @property string cc_status
* @property string echeck_routing_number
* @property string account_status
* @property string anet_trans_method
* @property string cc_debug_response_body
* @property string cc_ss_issue
* @property string echeck_account_name
* @property string cc_avs_status
* @property string cc_number_enc
* @property string cc_trans_id
* @property string address_status
* @property string additional_information
 */
class Payment extends Model
{
    protected $table = 'sales_order_payment';
    protected $primaryKey = 'entity_id';
    protected $guarded = [];
    public $timestamps = false;

}