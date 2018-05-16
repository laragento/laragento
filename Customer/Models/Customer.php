<?php

namespace Laragento\Customer\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;


/**
 * Customer model
 *
 * @property int $entity_id Entity Id
 * @property int|null $website_id Website Id
 * @property string|null $email Email
 * @property int $group_id Group Id
 * @property string|null $increment_id Increment Id
 * @property int|null $store_id Store Id
 * @property \Carbon\Carbon $created_at Created At
 * @property \Carbon\Carbon $updated_at Updated At
 * @property int $is_active Is Active
 * @property int $disable_auto_group_change Disable automatic group change based on VAT ID
 * @property string|null $created_in Created From
 * @property string|null $prefix Prefix
 * @property string|null $firstname First Name
 * @property string|null $middlename Middle Name/Initial
 * @property string|null $lastname Last Name
 * @property string|null $suffix Suffix
 * @property string|null $dob Date of Birth
 * @property string|null $password_hash Password_hash
 * @property string|null $rp_token Reset password token
 * @property string|null $rp_token_created_at Reset password token creation time
 * @property int|null $default_billing Default Billing Address
 * @property int|null $default_shipping Default Shipping Address
 * @property string|null $taxvat Tax/VAT Number
 * @property string|null $confirmation Is Confirmed
 * @property int|null $gender Gender
 * @property int|null $failures_num Failure Number
 * @property string|null $first_failure First Failure
 * @property string|null $lock_expires Lock Expiration Date
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Customer\Models\Address[] $addresses
 * @property-read \Laragento\Customer\Models\Address $billing
 * @property-read \Laragento\Customer\Models\Group $group
 * @property-read \Laragento\Customer\Models\Address $shipping
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereConfirmation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereCreatedIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereDefaultBilling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereDefaultShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereDisableAutoGroupChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereFailuresNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereFirstFailure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereIncrementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereLockExpires($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer wherePasswordHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereRpToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereRpTokenCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereTaxvat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Customer\Models\Customer whereWebsiteId($value)
 * @mixin \Eloquent
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