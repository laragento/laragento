<?php

namespace Laragento\Catalog\Http\Api;

use App\Http\Controllers\Controller;
use Laragento\Catalog\Repositories\Pricing\PriceRepositoryInterface;

class PriceApi extends Controller implements PriceApiInterface
{
    /**
     * @var PriceRepositoryInterface
     */
    protected $priceRepository;

    /**
     * ProductApi constructor.
     * @param PriceRepositoryInterface $priceRepository
     */
    public function __construct(
        PriceRepositoryInterface $priceRepository
    ) {
        $this->priceRepository = $priceRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function getRegularPrice($productId)
    {
        return response()->json($this->priceRepository::regularPrice($productId),200);
    }

    /**
     * {@inheritDoc}
     */
    public function getSpecialPrice($productId)
    {
        return response()->json($this->priceRepository::specialPrice($productId));
    }

    /**
     * {@inheritDoc}
     */
    public function getBasePrice($productId)
    {
        // TODO: Implement getBasePrice() method.
    }
}