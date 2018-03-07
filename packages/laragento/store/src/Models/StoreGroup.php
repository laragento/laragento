<?php

namespace Laragento\Store\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StoreGroup
 *
 * @package Laragento\Store\Models
 * @property int group_id
 * @property int website_id
 * @property string code
 * @property string name
 * @property int root_category_id
 * @property int default_store_id
 * @property int $group_id Group Id
 * @property int $website_id Website Id
 * @property string|null $code Store group unique code
 * @property string $name Store Group Name
 * @property int $root_category_id Root Category Id
 * @property int $default_store_id Default Store Id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Store\Models\Store[] $stores
 * @property-read \Laragento\Store\Models\StoreWebsite $website
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\StoreGroup whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\StoreGroup whereDefaultStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\StoreGroup whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\StoreGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\StoreGroup whereRootCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Store\Models\StoreGroup whereWebsiteId($value)
 * @mixin \Eloquent
 */
class StoreGroup extends Model
{
    protected $table = 'store_group';
    protected $fillable = [
        'group_id',
        'website_id',
        'code',
        'name',
        'root_category_id',
        'default_store_id',
    ];
    protected $primaryKey = 'group_id';
    public $timestamps = false;


    public function stores()
    {
        return $this->hasMany(Store::class, 'group_id', $this->primaryKey);
    }

    public function website()
    {
        return $this->belongsTo(StoreWebsite::class, 'website_id', 'website_id');

    }
}