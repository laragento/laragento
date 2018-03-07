<?php

namespace Laragento\Catalog\Models\Product\Entity\Media;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;


/**
 * Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValueToEntity
 *
 * @property int $value_id Value media Entry ID
 * @property int $entity_id Product entity ID
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValueToEntity whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValueToEntity whereValueId($value)
 * @mixin \Eloquent
 */
class MediaGalleryValueToEntity extends Model
{
    protected $table = 'catalog_product_entity_media_gallery_value_to_entity';
    protected $fillable = [
        'value_id',
        'entity_id',
    ];
    public $timestamps = false;
}