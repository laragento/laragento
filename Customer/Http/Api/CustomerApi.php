<?php

namespace Laragento\Customer\Http\Api;

use App\Http\Controllers\Controller;
use Laragento\Customer\Http\Requests\StoreCustomer;
use Laragento\Customer\Repositories\CustomerRepositoryInterface;
use Laragento\Customer\Transformers\AddressTransformer;
use Laragento\Customer\Transformers\CustomerTransformer;
use Laragento\Customer\Transformers\QuoteTransformer;
use Laragento\Customer\Transformers\GroupTransformer;
use Spatie\Fractal\Fractal;

class CustomerApi extends Controller implements CustomerApiInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * CustomerApi constructor.
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function first($identifier)
    {
        dd("Method Illuminate\Http\JsonResponse::toArray does not exist.");
        $customer = $this->customerRepository->first($identifier);
        $fractal = Fractal::create($customer, new CustomerTransformer());
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function forceFirst($identifier)
    {
        $customer = $this->customerRepository->forceFirst($identifier);
        $fractal = Fractal::create($customer, new QuoteTransformer());
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        $customers = $this->customerRepository->get();
        $fractal = Fractal::create($customers, new QuoteTransformer());
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        $customers = $this->customerRepository->all();
        $fractal = Fractal::create($customers, new QuoteTransformer());
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function find()
    {
        $customers = $this->customerRepository->find();
        $fractal = Fractal::create($customers, new QuoteTransformer());
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function store(StoreCustomer $request)
    {
        $customer = $this->customerRepository->store($request->all());
        $fractal = Fractal::create($customer, new QuoteTransformer());
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function group($customer_id)
    {
        $group = $this->customerRepository->group($customer_id);
        $fractal = Fractal::create($group, new GroupTransformer());
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function defaultShipping($customer_id)
    {
        $address = $this->customerRepository->defaultShipping($customer_id);
        $fractal = Fractal::create($address, new AddressTransformer());
        return response()->json($fractal, 200);
    }

    /**
     * {@inheritDoc}
     */
    public function defaultBilling($customer_id)
    {
        $address = $this->customerRepository->defaultBilling($customer_id);
        $fractal = Fractal::create($address, new AddressTransformer());
        if (!$address) {
            $fractal->addMeta([
                'message' => __('default_billing_address_not_found'),
                'error' => [
                    'code' => 'default_billing_address_not_found'
                ]
            ]);
        }
        return response()->json($fractal,200);
    }
}
