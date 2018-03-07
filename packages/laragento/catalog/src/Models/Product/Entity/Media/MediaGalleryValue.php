<?php

namespace Laragento\Catalog\Models\Product\Entity\Media;

use Illuminate\Database\Eloquent\Model;
use Laragento\Catalog\Models\Product\Product;


/**
 * Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValue
 *
 * @property int $value_id Value ID
 * @property int $store_id Store ID
 * @property int $entity_id Entity ID
 * @property string|null $label Label
 * @property int|null $position Position
 * @property int $disabled Is Disabled
 * @property int $record_id Record Id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laragento\Catalog\Models\Product\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValue whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValue whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValue whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValue wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValue whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValue whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValue whereValueId($value)
 * @mixin \Eloquent
 */
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