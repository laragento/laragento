<?php
namespace Laragento\Customer\Http\Api;

use Laragento\Core\Http\Api\ApiInterface;
use Laragento\Customer\Http\Requests\StoreCustomer;

interface CustomerApiInterface extends ApiInterface
{
    /**
     * @param StoreCustomer $request
     * @return mixed
     */
    public function store(StoreCustomer $request);

    /**
     * @param $customerId
     * @return mixed
     */
    public function group($customerId);

    /**
     * @param $customerId
     * @return mixed
     */
    public function defaultShipping($customerId);

    /**
     * @param $customerId
     * @return mixed
     */
    public function defaultBilling($customerId);
}