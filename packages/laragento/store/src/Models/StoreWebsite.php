<?php

namespace Laragento\Store\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StoreWebsite
 * @package Laragento\Store\Models
 * @property int website_id
 * @property string code
 * @property string name
 * @property int sort_order
 * @property int default_group_id
 * @property int is_default
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