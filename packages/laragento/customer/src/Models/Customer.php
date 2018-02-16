<?php

namespace Laragento\Customer\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Customer model
 * @property int entity_id
 * @property int website_id
 * @property string email
 * @property int group_id
 * @property int increment_id
 * @property int store_id
 * @property mixed created_at
 * @property mixed updated_at
 * @property int is_active
 * @property string created_in
 * @property string prefix
 * @property string firstname
 * @property string middlename
 * @property string lastname
 * @property string suffix
 * @property mixed dob
 * @property int default_billing
 * @property int default_shipping
 * @property int taxvat
 * @property int confirmation
 * @property string gender
 */
class Customer extends Model
{
    protected $table = 'customer_entity';
    protected $primaryKey = 'entity_id';

    protected $fillable = [
        'entity_id',
        'website_id',
        'email',
        'group_id',
        'increment_id',
        'store_id',
        'created_at',
        'updated_at',
        'is_active',
        'created_in',
        'prefix',
        'firstname',
        'middlename',
        'lastname',
        'suffix',
        'dob',
        'default_billing',
        'default_shipping',
        'taxvat',
        'confirmation',
        'gender'
    ];

    protected $hidden = [
        'disable_auto_group_change',
        'password_hash',
        'rp_token',
        'rp_token_created_at',
        'failures_num',
        'first_failure',
        'lock_expires',
    ];

    public function getEmail()
    {
        return $this->email;
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'parent_id', 'entity_id');
    }

    public function shipping()
    {
        return $this->hasOne(Address::class, 'entity_id', 'default_shipping');
    }

    public function billing()
    {
        return $this->hasOne(Address::class, 'entity_id', 'default_billing');
    }

    public function group()
    {
        return $this->hasOne(Group::class, 'customer_group_id', 'group_id');
    }

    public function delete()
    {
        $this->addresses()->delete();
        parent::delete();
    }
}