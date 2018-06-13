<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laragento\Sales\Tests\SalesTestCase;

class StoreOrderTest extends SalesTestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function storeOrder()
    {
        print_r('Hitting');
    }

}
