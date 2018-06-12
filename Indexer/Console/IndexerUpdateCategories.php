<?php

namespace Modules\BachmannkartenImport\Console;

use Illuminate\Console\Command;
use Laragento\Customer\Models\Address;
use Modules\BachmannkartenShop\Models\Customer;
use Laragento\Customer\Repositories\AddressRepositoryInterface;
use Laragento\Customer\Repositories\CustomerRepositoryInterface;
use Modules\BachmannkartenNavision\OData\Navision;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Validator;

class IndexerUpdateCategories extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'indexer:update-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update categories in index table.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo 'indexer:update-categories' . "\n";
    }
}
