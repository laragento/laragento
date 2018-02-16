<?php

namespace Laragento\Eav\Models\Option;

use Illuminate\Database\Eloquent\Model;
use Laragento\Store\Models\Store;

class AttributeOptionSwatch extends Model
{
    protected $table = 'eav_attribute_option_swatch';
    protected $fillable = [
        'swatch_id',
        'option_id',
        'type',
        'store_id',
        'value',
    ];
    protected $primaryKey = 'swatch_id';
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