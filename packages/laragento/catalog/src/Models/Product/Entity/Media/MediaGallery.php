<?php

namespace Laragento\Catalog\Models\Product\Entity\Media;

use Illuminate\Database\Eloquent\Model;
use Laragento\Eav\Models\Attribute;


/**
 * Laragento\Catalog\Models\Product\Entity\Media\MediaGallery
 *
 * @property int $value_id Value ID
 * @property int $attribute_id Attribute ID
 * @property string|null $value Value
 * @property string $media_type Media entry type
 * @property int $disabled Visibility status
 * @property-read \Laragento\Eav\Models\Attribute $attribute
 * @property-read \Laragento\Catalog\Models\Product\Entity\Media\MediaGalleryValue $label
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGallery whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGallery whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGallery whereMediaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGallery whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Laragento\Catalog\Models\Product\Entity\Media\MediaGallery whereValueId($value)
 * @mixin \Eloquent
 */
class MediaGallery extends Model
{
    protected $table = 'catalog_product_entity_media_gallery';
    protected $fillable = [
        'value_id',
        'attribute_id',
        'value',
        'media_type',
        'disabled',
    ];
    protected $primaryKey = 'value_id';
    public $timestamps = false;

    public function label()
    {
        return $this->hasOne(MediaGalleryValue::class, 'value_id', 'value_id');
    }

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'attribute_id', 'attribute_id');
    }
}