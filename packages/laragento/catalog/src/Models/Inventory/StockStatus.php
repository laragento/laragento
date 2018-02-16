<?php


namespace Laragento\Catalog\Models\Inventory;


use Illuminate\Database\Eloquent\Model;
use Laragento\Core\Traits\CompositePrimaryKeys;

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