<?php

namespace Laragento;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laragento\Catalog\Repositories\Product\ProductRepository;
use Laragento\CatalogImportExport\CatalogImportExportServiceProvider;
use Laragento\CatalogUrlRewrite\Providers\CatalogUrlRewriteServiceProvider;
use Laragento\Checkout\Providers\CheckoutServiceProvider;
use Laragento\Catalog\Providers\CatalogServiceProvider;
use Laragento\Core\Providers\CoreServiceProvider;
use Laragento\Customer\CustomerServiceProvider;
use Laragento\CustomerImportExport\Providers\CustomerImportExportServiceProvider;
use Laragento\Dev\Providers\DevServiceProvider;
use Laragento\Directory\Providers\DirectoryServiceProvider;
use Laragento\Eav\Providers\EavServiceProvider;
use Laragento\ImportExport\Providers\ImportExportServiceProvider;
use Laragento\Indexer\Providers\IndexerServiceProvider;
use Laragento\MediaStorage\Providers\MediaStorageServiceProvider;
use Laragento\Quote\Providers\QuoteServiceProvider;
use Laragento\Rating\Providers\RatingServiceProvider;
use Laragento\Review\Providers\ReviewServiceProvider;
use Laragento\Sales\Providers\SalesServiceProvider;
use Laragento\Store\Providers\StoreServiceProvider;
use Laragento\XmlChunk\Providers\XmlChunkServiceProvider;

class LaragentoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //dd("die already");
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(CatalogServiceProvider::class);
        $this->app->register(CatalogImportExportServiceProvider::class);
        $this->app->register(CatalogUrlRewriteServiceProvider::class);
        $this->app->register(SalesServiceProvider::class);
        $this->app->register(CheckoutServiceProvider::class);
        $this->app->register(CoreServiceProvider::class);
        $this->app->register(CustomerServiceProvider::class);
        $this->app->register(CustomerImportExportServiceProvider::class);
        $this->app->register(DirectoryServiceProvider::class);
        $this->app->register(EavServiceProvider::class);
        $this->app->register(ImportExportServiceProvider::class);
        $this->app->register(MediaStorageServiceProvider::class);
        $this->app->register(QuoteServiceProvider::class);
        $this->app->register(RatingServiceProvider::class);
        $this->app->register(ReviewServiceProvider::class);
        $this->app->register(StoreServiceProvider::class);
        $this->app->register(XmlChunkServiceProvider::class);
        $this->app->register(IndexerServiceProvider::class);
    }
}
