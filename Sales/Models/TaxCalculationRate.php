<?php

namespace Laragento\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Laragento\Customer\Models\Customer;
use Laragento\Sales\Models\Order\Address;
use Laragento\Sales\Models\Order\Item;
use Laragento\Store\Models\Store;

/**
# @propertz int tax_calculation_rate_id
# @propertz string tax_country_id
# @propertz int tax_region_id
# @propertz string tax_postcode
# @propertz string code
# @propertz float rate
# @propertz int zip_is_range
# @propertz int zip_from
# @propertz int zip_to
 */
class TaxCalculationRate extends Model
{
    protected $table = 'tax_calculation_rate';
    protected $primaryKey = 'tax_calculation_rate_id';
    protected $guarded = [];



}