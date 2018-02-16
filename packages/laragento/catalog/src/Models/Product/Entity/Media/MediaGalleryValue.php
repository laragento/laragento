<?php

namespace Laragento\Catalog\Models\Product\Entity\Media;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;


class MediaGalleryValue extends Model
{
    protected $table = 'catalog_product_entity_media_gallery_value';
    protected $fillable = [
        'value_id',
        'store_id',
        'entity_id',
        'label',
        'position',
        'disabled',
        'record_id',
    ];
    protected $primaryKey = 'record_id';
    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'catalog_product_entity_media_gallery_value_to_entity',
            'value_id',
            'entity_id');
    }
}