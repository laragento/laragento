<?php


namespace Laragento\Catalog\Models\Inventory;


use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\ProductWebsite;

/**
 * Laragento\Catalog\Models\Inventory\Stock
 *
 * @property int $stock_id Stock Id
 * @property int $website_id Website Id
 * @property string|null $stock_name Stock Name
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\Stock whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\Stock whereStockName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\Stock whereWebsiteId($value)
 * @mixin \Eloquent
 */
class Stock extends Model
{
    protected $table = 'cataloginventory_stock';
    protected $fillable = [
        'website_id',
        'stock_id',
        'stockname',
    ];
    protected $primaryKey = 'stock_id';

}