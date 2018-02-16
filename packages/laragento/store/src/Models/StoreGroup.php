<?php

namespace Laragento\Store\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StoreGroup
 * @package Laragento\Store\Models
 * @property int group_id
 * @property int website_id
 * @property string code
 * @property string name
 * @property int root_category_id
 * @property int default_store_id
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