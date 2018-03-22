<?php

namespace Laragento\Catalog\Repositories\Media;

interface ImageRepositoryInterface
{

    public function saveImages($files, $productId, $label = '', $links = null);

    public function saveImage($fileName, $productId, $label = '', $links = null);
}