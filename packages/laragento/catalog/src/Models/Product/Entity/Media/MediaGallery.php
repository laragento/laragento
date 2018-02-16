<?php

namespace Laragento\Catalog\Models\Product\Entity\Media;

use Illuminate\Database\Eloquent\Model;
use Laragento\Eav\Models\Attribute;


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