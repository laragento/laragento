<?php

namespace Laragento\Store\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StoreWebsite
 *
 * @package Laragento\Store\Models
 * @property int website_id
 * @property string code
 * @property string name
 * @property int sort_order
 * @property int default_group_id
 * @property int is_default
 * @property int $website_id Website Id
 * @property string|null $code Code
 * @property string|null $name Website Name
 * @property int $sort_order Sort Order
 * @property int $default_group_id Default Group Id
 * @property int|null $is_default Defines Is Website Default
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Store\Models\StoreGroup[] $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Store\Models\Store[] $stores
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\StoreWebsite whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\StoreWebsite whereDefaultGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\StoreWebsite whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\StoreWebsite whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\StoreWebsite whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\StoreWebsite whereWebsiteId($value)
 * @mixin \Eloquent
 */
class StoreWebsite extends Model
{
    protected $table = 'store_website';
    protected $fillable = [
        'website_id',
        'code',
        'name',
        'sort_order',
        'default_group_id',
        'is_default',
    ];
    protected $primaryKey = 'website_id';
    public $timestamps = false;

    public function groups()
    {
        return $this->hasMany(StoreGroup::class, 'website_id', $this->primaryKey);
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'website_id', $this->primaryKey);
    }
}