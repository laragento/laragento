<?php

class ProductLinkRepositoryTest extends AbstractProductRepositoryTest
{
    /**
     * @test
     */
    public function get_up_sell_relations()
    {
        $upSell = $this->productLinkRepository->getUpsell($this->simpleProduct->getKey());
        $this->assertEquals($this->simpleProduct->getKey(), $upSell->first()->entity_id);
    }

    /**
     * @test
     */
    public function get_up_sell_products()
    {
        $upSells = $this->productRepository->links($this->simpleProduct->getKey());

        dd($upSells->toArray());
        $this->assertEquals($this->simpleProduct->getKey(), $upSell->first()->product_id);
    }


}