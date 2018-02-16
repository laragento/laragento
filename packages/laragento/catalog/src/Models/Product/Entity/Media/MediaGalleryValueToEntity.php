<?php

namespace Laragento\Catalog\Models\Product\Entity\Media;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;


class MediaGalleryValueToEntity extends Model
{
    protected $table = 'catalog_product_entity_media_gallery_value_to_entity';
    protected $fillable = [
        'value_id',
        'entity_id',
    ];
    public $timestamps = false;
}