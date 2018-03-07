<?php


namespace Laragento\Catalog\Models\Inventory;


use Illuminate\Database\Eloquent\Model;
use Laragento\Core\Traits\CompositePrimaryKeys;

/**
 * Laragento\Catalog\Models\Inventory\StockStatus
 *
 * @property int $product_id Product Id
 * @property int $website_id Website Id
 * @property int $stock_id Stock Id
 * @property float $qty Qty
 * @property int $stock_status Stock Status
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockStatus whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockStatus whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockStatus whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockStatus whereStockStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Inventory\StockStatus whereWebsiteId($value)
 * @mixin \Eloquent
 */
class StockStatus extends Model
{
    use CompositePrimaryKeys;

    protected $table = 'cataloginventory_stock_status';
    protected $fillable = [
        'product_id',
        'website_id',
        'stock_id',
        'qty',
        'stock_status'
    ];
    protected $primaryKey = ['product_id', 'stock_id', 'website_id'];
    public $incrementing = false;
    public $timestamps = false;


    public function __construct(array $attributes = [])
    {
        $this->setIgnoredPrimaryKeys(['website_id']);
        parent::__construct($attributes);
    }


}