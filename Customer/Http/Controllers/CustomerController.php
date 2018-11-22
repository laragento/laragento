<?php

namespace Laragento\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use Laragento\Customer\Repositories\CustomerRepositoryInterface;

class CustomerController extends Controller
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * CustomerController constructor.
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }
}
