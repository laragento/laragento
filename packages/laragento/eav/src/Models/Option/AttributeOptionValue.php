<?php

namespace Laragento\Eav\Models\Option;

use Illuminate\Database\Eloquent\Model;
use Laragento\Store\Models\Store;

class AttributeOptionValue extends Model
{
    protected $table = 'eav_attribute_option_value';
    protected $fillable = [
        'value_id',
        'option_id',
        'store_id',
        'value',
    ];
    protected $primaryKey = 'value_id';
    public $timestamps = false;

    public function option()
    {
        return $this->hasOne(AttributeOption::class, 'option_id', 'option_id');
    }

    public function store()
    {
        return $this->hasOne(Store::class, 'store_id', 'store_id');
    }
}