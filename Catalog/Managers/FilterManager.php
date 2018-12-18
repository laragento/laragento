<?php

namespace Laragento\Catalog\Managers;

use Laragento\Catalog\Repositories\Catalog\CatalogAttributeRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductAttributeRepositoryInterface;
use Laragento\Catalog\Repositories\Product\ProductRepositoryInterface;

class FilterManager
{
    protected $productRepository;
    protected $productAttributeRepository;
    protected $catalogAttributeRepository;
    protected $allProducts = [];
    protected $relatedProducts = null;
    protected $allDisplayAvailable = [];
    public $filters = [];
    public $filterLabels = [];
    public $filterOptionLabels = [];
    public $priceFrom = null;
    public $priceTo = 100;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductAttributeRepositoryInterface $productAttributeRepository,
        CatalogAttributeRepositoryInterface $catalogAttributeRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->catalogAttributeRepository = $catalogAttributeRepository;
    }


    /**
     * @param $relatedProducts
     * @param $filterableAttributes
     * @param $paginationConfig
     * @param null $filters
     * @param null $sort
     * @return null
     */
    public function applyFiltersAndSorting(
        $relatedProducts,
        $filterableAttributes,
        $paginationConfig,
        $filters = null,
        $sort = null
    ) {
        if ($filters == null) {
            $filters = request()->get('filters');
        }
        if ($sort == null) {
            $sort = request()->get('sort');
        }
        if (request()->get('price_from')) {
            $this->priceFrom = request()->get('price_from');
        }
        if (request()->get('price_to')) {
            $this->priceTo = request()->get('price_to');
        }

        $this->initialize($relatedProducts, $filterableAttributes);
        $this->setActiveFilters($filters);
        $this->filter();
        $this->sort($sort);
        $this->paginate($paginationConfig);
        $this->inactivateFilterOptions();
        $this->getFilterAttributeLabels();
        return $this->getRelatedProducts();
    }

    /**
     *
     */
    public function getFilterAttributeLabels()
    {
        foreach ($this->catalogAttributeRepository->filterableAttributes() as $filterLabel) {
            $this->filterLabels[$filterLabel->attribute_code] = $filterLabel->frontend_label;
        }
        $this->filterOptionLabels = $this->catalogAttributeRepository->indexedAttributeOptionValues(
            $this->getAllDisplayAvailable()
        );
    }

    /**
     * @param $filters
     */
    public function setFilter($filters)
    {
        if (is_array($filters)) {
            foreach ($filters as $filterCode) {
                $this->filters[$filterCode] =
                    [
                        'available' => [],
                        'active' => [],
                        'display_available' => [],
                        'display_inactive' => []
                    ];
            }
        }
    }

    /**
     * @param $relatedProducts
     * @param $filterableAttributes
     */
    public function initialize($relatedProducts, $filterableAttributes)
    {
        $this->setFilter($filterableAttributes);
        $this->relatedProducts = $relatedProducts;
        $this->allProducts = $relatedProducts->get($filterableAttributes);

        $this->setAvailableFilters();
    }

    /**
     *
     */
    public function setAvailableFilters()
    {
        foreach ($this->allProducts as $i => $product) {
            foreach ($this->filters as $key => $value) {
                if ($key == 'price') {
                    continue;
                }
                if ($product[$key] != '' && !in_array($product[$key], $this->filters[$key]['available'])) {
                    $this->filters[$key]['available'][] = $product[$key];
                }
            }
        }

        foreach ($this->filters as $key => $value) {
            if (count($this->filters[$key]['available']) < 1) {
                return 0;
            }

            $this->filters[$key]['display_available'] = array_unique(explode(",",
                implode(",", $this->filters[$key]['available'])));
            $this->filters[$key]['display_inactive'] = $this->filters[$key]['display_available'];
            $this->allDisplayAvailable = array_merge($this->allDisplayAvailable,
                $this->filters[$key]['display_available']);
        }
    }

    public function getAllDisplayAvailable()
    {
        return $this->allDisplayAvailable;
    }

    /**
     * @return array
     * @todo improve
     */
    public function inactivateFilterOptions()
    {
        $mainFilter = false;
        foreach ($this->relatedProducts as $product) {
            foreach ($this->filters as $key => $value) {
                if ($this->filters[$key]['display_inactive'] == []) {
                    continue;
                }
                if (count($this->filters[$key]['active']) > 0 && ($mainFilter == false || $mainFilter == $key)) {
                    $mainFilter = $key;
                    continue;
                }
                $currentAttributeProductOptions = explode(",", $product[$key]);
                $this->filters[$key]['display_inactive'] = array_diff(
                    $this->filters[$key]['display_inactive'],
                    $currentAttributeProductOptions);
            }
        }

        foreach ($this->filters as $key => $value) {
            if ($this->filters[$key]['display_available'] == []) {
                continue;
            }
            if ($mainFilter == $key) {
                $this->filters[$key]['display_inactive'] = [];
                continue;
            }
            $this->filters[$key]['display_available'] = array_diff(
                $this->filters[$key]['display_available'],
                $this->filters[$key]['display_inactive']);
        }

        return $this->filters;
    }

    /**
     * @param $requestFilters
     * @return array
     */
    public function setActiveFilters($requestFilters)
    {

        if (is_array($requestFilters) && count($requestFilters) > 0) {
            foreach ($requestFilters as $requestFilter) {
                foreach ($this->filters as $key => $value) {
                    foreach ($this->filters[$key]['available'] as $availableFilter) {
                        if (in_array($requestFilter, explode(",", $availableFilter))) {
                            $this->filters[$key]['active'][] = $availableFilter;
                        }
                    }
                }
            }
        }
        return $this->filters;
    }

    /**
     * @return null
     */
    public function filter()
    {
        foreach ($this->filters as $key => $value) {
            if (count($this->filters[$key]['active']) > 0) {
                $activeFiltersOptions = $this->filters[$key]['active'];
                $this->relatedProducts->where(function ($query) use ($activeFiltersOptions, $key) {
                    foreach ($activeFiltersOptions as $activeFilterOption) {
                        $query->orWhere($key, $activeFilterOption);
                    }
                });
            }
            if (array_key_exists('price', $this->filters)) {
                // Price Range Filter
                if ($this->priceFrom && $this->priceTo) {
                    $this->relatedProducts->whereBetween('price', [$this->priceFrom, $this->priceTo]);
                }
            }
        }
        return $this->relatedProducts;
    }

    /**
     * @param $sort
     * @return null
     */
    public function sort($sort)
    {
        //sort products based on sort param in the request
        switch ($sort) {
            case 'name':
                $this->relatedProducts = $this->relatedProducts->orderBy('name');
                break;
            case 'name_desc':
                $this->relatedProducts = $this->relatedProducts->orderBy('name', 'desc');
                break;
            case 'price_desc':
                $this->relatedProducts = $this->relatedProducts->orderBy('price', 'desc');
                break;
            default:
                $this->relatedProducts = $this->relatedProducts->orderBy('price'); //set default sorting by price
        }
        return $this->relatedProducts;
    }

    /**
     * @param $config
     * @return mixed
     */
    public function paginate($config)
    {
        $this->relatedProducts = $this->relatedProducts->paginate($config);
        return $this->relatedProducts;
    }

    public function getRelatedProducts()
    {
        return $this->relatedProducts;
    }

}