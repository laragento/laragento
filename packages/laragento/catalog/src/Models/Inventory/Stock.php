<?php


namespace Laragento\Catalog\Models\Inventory;


use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\ProductWebsite;

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