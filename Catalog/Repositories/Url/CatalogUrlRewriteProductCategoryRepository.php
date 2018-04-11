<?php


namespace Laragento\Catalog\Repositories\Url;


use Laragento\Catalog\Models\Url\CatalogUrlRewriteProductCategory;

class CatalogUrlRewriteProductCategoryRepository implements CatalogUrlRewriteProductCategoryRepositoryInterface
{

    public function find($id)
    {
        return CatalogUrlRewriteProductCategory::with([
            'product',
            'category',
        ])
            ->find($id)
            ->first();
    }

    public function findAllByProduct($productId)
    {
        return CatalogUrlRewriteProductCategory::with([
            'product',
            'category',
        ])
            ->where(['product_id' => $productId])
            ->get();
    }

    public function findAllByCategory($categoryId)
    {
        return CatalogUrlRewriteProductCategory::with([
            'product',
            'category',
        ])
            ->where(['product_id' => $categoryId])
            ->get();
    }

    public function findAllByCategoryProduct($entry)
    {
        return CatalogUrlRewriteProductCategory::with([
            'product',
            'category',
        ])
            ->where([
                'product_id' => $entry['product_id'],
                'category_id' => $entry['category_id']
            ])
            ->first();
    }

    public function store($entry)
    {
        $rewriteEntry = CatalogUrlRewriteProductCategory::where([
            'product_id' => $entry['product_id'],
            'category_id' => $entry['category_id']
        ])->first();

        if (!$rewriteEntry) {
            $rewriteEntry = new CatalogUrlRewriteProductCategory($entry);
            $rewriteEntry->save();
        } else {
            $rewriteEntry->update($entry);
        }
    }


    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    public function save($rewriteEntry)
    {
        // TODO: Implement save() method.
    }
}