<?php

namespace Laragento\Store\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Store
 *
 * @package Laragento\Store\Models
 * @property int $store_id Store Id
 * @property string|null $code Code
 * @property int $website_id Website Id
 * @property int $group_id Group Id
 * @property string $name Store Name
 * @property int $sort_order Store Sort Order
 * @property int $is_active Store Activity
 * @property-read \Laragento\Store\Models\StoreGroup $group
 * @property-read \Laragento\Store\Models\StoreWebsite $website
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\Store whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\Store whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\Store whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\Store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\Store whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\Store whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\Store whereWebsiteId($value)
 * @mixin \Eloquent
 */
class Store extends Model
{
    protected $table = 'store';
    protected $fillable = [
        'store_id',
        'code',
        'website_id',
        'group_id',
        'name',
        'sort_order',
        'is_active'
    ];
    protected $primaryKey = 'store_id';
    public $timestamps = false;

    public function website()
    {
        return $this->belongsTo(StoreWebsite::class, 'website_id', 'website_id');
    }

    public function group()
    {
        return $this->belongsTo(StoreGroup::class, 'group_id', 'group_id');
    }
}