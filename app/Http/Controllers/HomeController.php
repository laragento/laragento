<?php

namespace App\Http\Controllers;

use Laragento\Catalog\Support\Facades\ProductFacade as Product;
use Laragento\Catalog\Support\Facades\CategoryFacade as Category;
use Laragento\Customer\Http\Api\CustomerApi as Customer;
use Laragento\Customer\Repositories\CustomerRepository;

class HomeController extends Controller
{
    public function show()
    {
        $customer = new Customer(new CustomerRepository());
        $result = $customer->first(2200)->toArray();

        return $result;
    }


    public function index()
    {
        return Category::all();
        //return Product::newest(2);

//            return view('laragento.home',
//                  [
//                        'newest' => Product::newest(4)
//                  ]);
    }
}
