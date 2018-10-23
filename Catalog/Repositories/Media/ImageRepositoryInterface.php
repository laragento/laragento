<?php

namespace Laragento\Catalog\Repositories\Media;

interface ImageRepositoryInterface
{
    public function saveImage($fileName, $productId);
}