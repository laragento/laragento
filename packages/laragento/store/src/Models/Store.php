<?php

namespace Laragento\Store\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Store
 * @package Laragento\Store\Models
 * @property int store_id
 * @property string code
 * @property int website_id
 * @property int group_id
 * @property string name
 * @property int sort_order
 * @property int is_active
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