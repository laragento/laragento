<?php

namespace Laragento\Customer\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Group model
 * @property int customer_group_id
 * @property string customer_group_code
 * @property int tax_class_id
 */
class Group extends Model
{
    protected $table = 'customer_group';
    protected $fillable = [
        'customer_group_id',
        'customer_group_code',
        'tax_class_id'
    ];
    protected $primaryKey = 'customer_group_id';

    public function customers()
    {
        return $this->hasMany(Customer::class, 'group_id', 'customer_group_id');
    }
}