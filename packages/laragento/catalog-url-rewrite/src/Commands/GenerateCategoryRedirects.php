<?php

namespace Laragento\CatalogUrlRewrite\Commands;

use Illuminate\Console\Command;
use Laragento\CatalogUrlRewrite\Managers\CatalogUrlRewriteManager;
use Laragento\Eav\Repositories\AttributeRepository;

class GenerateCategoryRedirects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lg:generate-category-redirects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * InitialMetaImport constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $manager = new CatalogUrlRewriteManager(
            new AttributeRepository()
        );

        $manager->generateUrlRewrites('category');
    }
}
