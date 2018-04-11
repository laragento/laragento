<?php


namespace Laragento\Catalog\Repositories\Product;


use Laragento\Catalog\Models\Product\Link\ProductLink;
use Laragento\Catalog\Models\Product\Link\ProductLinkAttribute;
use Laragento\Catalog\Models\Product\Link\ProductLinkAttributeDecimal;
use Laragento\Catalog\Models\Product\Link\ProductLinkAttributeInteger;
use Laragento\Catalog\Models\Product\Link\ProductLinkAttributeVarchar;

class ProductLinkRepository implements ProductLinkRepositoryInterface
{
    protected $errors;

    public function store($productId, $linkedProductId, $linkTypeId, $value = null)
    {
        $productLink = $this->find($productId, $linkedProductId);
        if (!$productLink) {
            $newProductLink = new ProductLink([
                'product_id' => $productId,
                'linked_product_id' => $linkedProductId,
                'link_type_id' => $linkTypeId,
            ]);
            $newProductLink->save();
            $this->saveChildAttributes($newProductLink, $value);
            return true;
        }
        return false;
    }

    public function find($productId, $linkedProductId)
    {
        $productLink = ProductLink::where([
            'product_id' => $productId,
            'linked_product_id' => $linkedProductId,
        ])->first();

        return $productLink;
    }

    public function findAttributeByType($typeId)
    {
        $condition = [
            'link_type_id' => $typeId,
        ];
        return ProductLinkAttribute::where($condition)->get();
    }

    public function findAttributeByTypeAndCode($typeId, $attributeCode)
    {
        $condition = [
            'link_type_id' => $typeId,
            'product_link_attribute_code' => $attributeCode,
        ];
        return ProductLinkAttribute::where($condition)->first();
    }

    private function saveChildAttributes($productLink, $linkValue = 0)
    {
        // We are checking which childattributes we have to save
        $linkAttributes = $this->findAttributeByType($productLink->link_type_id);

        foreach ($linkAttributes as $linkAttribute) {

            switch ($linkAttribute['data_type']) {
                case 'varchar':
                    //ToDo: Not sure about the value
                    $newAttributeLink = new ProductLinkAttributeVarchar(['value' => $linkValue]);
                    break;
                case 'int':
                    $newAttributeLink = new ProductLinkAttributeInteger(['value' => $linkValue]);
                    break;
                case 'decimal':
                    $newAttributeLink = new ProductLinkAttributeDecimal(['value' => 0]);
                    break;
                default:
                    $newAttributeLink = null;
                    $this->errors[] = 'ProductLinkAttribute ' . $linkAttribute['data_type'] . ' not matching';
            }
            if ($newAttributeLink) {
                $newAttributeLink->productLinkAttribute()->associate($linkAttribute);
                $newAttributeLink->link()->associate($productLink);
                $newAttributeLink->save();
            } else {
                print_r('Errors on saving AttributeLink');
            }
        }

    }

}