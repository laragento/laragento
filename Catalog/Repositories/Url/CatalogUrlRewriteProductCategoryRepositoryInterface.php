<?php


namespace Laragento\Catalog\Repositories\Url;


interface CatalogUrlRewriteProductCategoryRepositoryInterface
{

    public function find($id);

    public function findAllByProduct($productId);

    public function findAllByCategory($categoryId);

    public function findAllByCategoryProduct($rewriteEntry);

    public function save($rewriteEntry);

    public function remove($id);
}