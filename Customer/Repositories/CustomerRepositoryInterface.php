<?php

namespace Laragento\Customer\Repositories;

use Laragento\Core\Repositories\RepositoryInterface;
use Laragento\Customer\Models\Address;
use Laragento\Customer\Models\Customer;

interface CustomerRepositoryInterface extends RepositoryInterface
{
    /**
     * @param $customerData
     * @return Customer
     */
    public function store($customerData);

    /**
     * @param $email
     * @return mixed
     */
    public function firstByEmail($email);

    /**
     * @param $customerId
     * @return mixed
     */
    public function firstById($customerId);

    /**
     * @param $customerId
     * @return mixed
     */
    public function group($customerId);

    /**
     * @param $customerId
     * @return Address
     */
    public function defaultShipping($customerId);

    /**
     * @param $customerId
     * @return Address
     */
    public function defaultBilling($customerId);

    /**
     * @param $email
     */
    public function destroyByEmail($email);

    /**
     * @param $email
     * @return mixed
     */
    public static function getIdByEmail($email);
}