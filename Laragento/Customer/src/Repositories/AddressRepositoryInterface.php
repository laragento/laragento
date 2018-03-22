<?php

namespace Laragento\Customer\Repositories;

use Laragento\Core\Repositories\RepositoryInterface;
use Laragento\Customer\Models\Address;

interface AddressRepositoryInterface extends RepositoryInterface
{
    /**
     * @param $addressData
     * @return Address
     */
    public function store($addressData);

    /**
     * @param $customerId
     * @return mixed
     */
    public function getByCustomerId($customerId);

    /**
     * @param $customerId
     * @return mixed
     */
    public function allByCustomerId($customerId);
}