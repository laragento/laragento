<?php


namespace Laragento\Catalog\Models\Inventory;


use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;


/**
 * Laragento\Catalog\Models\Inventory\StockItem
 *
 * @property int $item_id Item Id
 * @property int $product_id Product Id
 * @property int $stock_id Stock Id
 * @property float|null $qty Qty
 * @property float $min_qty Min Qty
 * @property int $use_config_min_qty Use Config Min Qty
 * @property int $is_qty_decimal Is Qty Decimal
 * @property int $backorders Backorders
 * @property int $use_config_backorders Use Config Backorders
 * @property float $min_sale_qty Min Sale Qty
 * @property int $use_config_min_sale_qty Use Config Min Sale Qty
 * @property float $max_sale_qty Max Sale Qty
 * @property int $use_config_max_sale_qty Use Config Max Sale Qty
 * @property int $is_in_stock Is In Stock
 * @property string|null $low_stock_date Low Stock Date
 * @property float|null $notify_stock_qty Notify Stock Qty
 * @property int $use_config_notify_stock_qty Use Config Notify Stock Qty
 * @property int $manage_stock Manage Stock
 * @property int $use_config_manage_stock Use Config Manage Stock
 * @property int $stock_status_changed_auto Stock Status Changed Automatically
 * @property int $use_config_qty_increments Use Config Qty Increments
 * @property float $qty_increments Qty Increments
 * @property int $use_config_enable_qty_inc Use Config Enable Qty Increments
 * @property int $enable_qty_increments Enable Qty Increments
 * @property int $is_decimal_divided Is Divided into Multiple Boxes for Shipping
 * @property int $website_id Is Divided into Multiple Boxes for Shipping
 * @property-read \Laragento\Catalog\Models\Product\Product $product
 * @property-read \Laragento\Catalog\Models\Inventory\Stock $stock
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereBackorders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereEnableQtyIncrements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereIsDecimalDivided($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereIsInStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereIsQtyDecimal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereLowStockDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereManageStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereMaxSaleQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereMinQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereMinSaleQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereNotifyStockQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereQtyIncrements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereStockStatusChangedAuto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereUseConfigBackorders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereUseConfigEnableQtyInc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereUseConfigManageStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereUseConfigMaxSaleQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereUseConfigMinQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereUseConfigMinSaleQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereUseConfigNotifyStockQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereUseConfigQtyIncrements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockItem whereWebsiteId($value)
 * @mixin \Eloquent
 */
class StockItem extends Model
{

    protected $table = 'cataloginventory_stock_item';
    public $timestamps = false;
    protected $fillable = [
        'item_id',
        'product_id',
        'stock_id',
        'qty',
        'min_qty',
        'use_config_min_qty',
        'is_qty_decimal',
        'backorders',
        'use_config_backorders',
        'min_sale_qty',
        'use_config_min_sale_qty',
        'max_sale_qty',
        'use_config_max_sale_qty',
        'is_in_stock',
        'low_stock_date',
        'notify_stock_qty',
        'use_config_notify_stock_qty',
        'manage_stock',
        'use_config_manage_stock',
        'stock_status_changed_auto',
        'use_config_qty_increments',
        'qty_increments',
        'use_config_enable_qty_inc',
        'enable_qty_increments',
        'is_decimal_divided',
        'website_id',
    ];
    protected $primaryKey = 'item_id';

    public function product()
    {
        return $this->hasOne(Product::class, 'product_id');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'stock_id');
    }
}