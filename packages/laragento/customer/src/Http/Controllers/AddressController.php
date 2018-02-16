<?php

namespace Laragento\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use Laragento\Customer\Http\Requests\StoreAddress;
use Laragento\Customer\Repositories\AddressRepositoryInterface;
use Laragento\Customer\Transformers\AddressTransformer;
use Spatie\Fractal\Fractal;

class AddressController extends Controller
{
    /**
     * @var AddressRepositoryInterface
     */
    protected $addressRepository;

    /**
     * AddressController constructor.
     * @param AddressRepositoryInterface $addressRepository
     */
    public function __construct(AddressRepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * @param $customerId
     * @return \Spatie\Fractalistic\Fractal
     */
    public function addresses($customerId)
    {
        $addresses = $this->addressRepository->getByCustomerId($customerId);
        return Fractal::create($addresses, new AddressTransformer());
    }

    /**
     * @param $addressId
     * @return \Spatie\Fractalistic\Fractal
     */
    public function address($addressId)
    {
        $address = $this->addressRepository->first($addressId);
        return Fractal::create($address, new AddressTransformer());
    }

    /**
     * @param StoreAddress $request
     * @return \Spatie\Fractalistic\Fractal
     */
    public function store(StoreAddress $request)
    {
        // @todo check if parent_id is_allowed
        // @todo use request
        $address = $this->addressRepository->store($request->all());
        return Fractal::create($address, new AddressTransformer());
    }
}
