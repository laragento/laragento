<?php

namespace Laragento\CustomerImportExport\Repositories;

use Illuminate\Validation\ValidationException;
use Laragento\Customer\Repositories\CustomerRepositoryInterface;
use Laragento\CustomerImportExport\Http\Requests\ImportAddressRequest;
use Laragento\CustomerImportExport\Http\Requests\ImportCustomerRequest;
use Validator;
use Laragento\Customer\Models\Address;
use Illuminate\Support\Facades\File;


class CustomerImportRepository implements CustomerImportRepositoryInterface
{
    protected $errors = [];
    protected $config = [];
    protected $customerRepository;
    protected $duplicateEmailAddresses = [];
    protected $addressIds = [];
    protected $uniqueProperties;
    protected $addressesToStore;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }


    /**
     * @param $config
     */
    public function configure($config)
    {
        $this->config($config);
    }

    /**
     * @param $customers
     * @return array
     * @todo set default billing / shipping
     * @todo refactor!
     * @todo second address not saving
     *
     */
    public function import($customers)
    {
        foreach ($customers['data'] as $customerData) {
            $customerModel = $this->saveCustomer($customerData);
            if ($customerModel) {
                print_r($customerModel->entity_id . ' ');
                $this->saveAddresses($customerData);
                if (!empty($this->addressIds)) {
                    $customerModel = $this->handleBillingAndShipping($customerModel);
                    $customerModel->addresses()->saveMany($this->addressesToStore);
                    $customerModel->save();
                }
            }
            $this->addressIds = [];
            $this->addressesToStore = [];
        }

        $errors = $this->getErrors();
        //print_r($errors);
        return $errors;
    }

    /**
     * @param $customer
     * @return null
     */
    public function saveCustomer($customer)
    {
        //$importTransformer = new CustomerImportTransformer();
        //$customer = $importTransformer->transform($customerData);
        if ($this->validCustomer($customer)) {
            $this->uniqueProperty($customer['email'], 'email');
            return $this->customerRepository->store($customer);
        }
        return null;
    }

    /**
     * @param $address
     */
    public function collectAddress($address)
    {
        //$importTransformer = new AddressImportTransformer();
        //$address = $importTransformer->transform($addressData);
        if ($this->validAddress($address)) {

            $isDefaultBilling = 0;
            $isDefaultShipping = 0;
            if (isset($address['default_billing']) && $address['default_billing']) {
                $isDefaultBilling = $address['default_billing'];
            }
            if (isset($address['default_shipping']) && $address['default_shipping']) {
                $isDefaultShipping = $address['default_shipping'];
            }
            unset($address['region_code']);
            unset($address['default_billing']);
            unset($address['default_shipping']);

            $addressObj = Address::firstOrCreate($address);
            //$addressObj = Address::firstOrNew($address);

            if ($isDefaultBilling) {
                $addressObj->setDefaultBilling(1);
            }
            if ($isDefaultShipping) {
                $addressObj->setDefaultShipping(1);
            }

            $this->addressesToStore[] = $addressObj;
            $this->addressIds[] = $addressObj->entity_id;
        }
    }


    /**
     * @param $address
     * @return bool
     */
    public function validAddress($address)
    {
        return $this->validate(new ImportAddressRequest(), $address, 'address-import');
    }

    /**
     * @param $customer
     * @return bool
     */
    protected function validCustomer($customer)
    {
        return $this->validate(new ImportCustomerRequest(), $customer, 'customer-import');
    }

    /**
     * @param $request
     * @param array $reference
     * @param string $element
     * @return bool
     * @todo ValidationException
     */
    protected function validate($request, $reference, $element)
    {
        $validator = Validator::make($reference, $request->rules());

        try {
            $validator->validate();
        } catch (ValidationException $exception) {

        }

        if ($validator->errors()->any()) {
            $this->errors[$element][] = [
                'errors' => $validator->errors(),
                'reference' => json_encode($reference)
            ];

            foreach ($validator->errors()->all() as $error) {
                $taxvat = '';
                $email = '';
                if (isset($reference['taxvat'])) {
                    $taxvat = $reference['taxvat'];
                }
                if (isset($reference['email'])) {
                    $email = $reference['email'];
                }
                File::append(
                    storage_path('app/import-export/shop_export/status/customer_status.csv'),
                    '"' . $error
                    . '";"' . $reference['firstname']
                    . ' ' . $reference['lastname']
                    . '";"' . $taxvat
                    . '";"' . $email . '"'
                    . PHP_EOL);
            }

            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        //print_r($this->uniqueProperties);
        foreach ($this->uniqueProperties as $key => $properties) {
            foreach ($properties as $entryKey => $property) {
                if ($key == 'email') {
                    if ($property >= 1) {
                        $this->errors['duplicate-email-addresses'][] = [
                            'errors' => 'There are duplicate email addresses in this import',
                            'reference' => $key . ' = ' . $entryKey
                        ];
                        File::append(
                            storage_path('app/import-export/shop_export/status/customer_status.csv'),
                            '"' . 'There are duplicate email addresses in this import'
                            . '";"'
                            . ' '
                            . '";"'
                            . '";"' . $entryKey . '"'
                            . PHP_EOL);

                    }
                }
            }
        }
        return $this->errors;
    }

    /**
     * @param $property
     * @param $key
     */
    protected function uniqueProperty($property, $key)
    {
        if (isset($this->uniqueProperties[$key][$property])) {
            $this->uniqueProperties[$key] = [$property => $this->uniqueProperties[$key][$property] + 1];
        } else {
            $this->uniqueProperties[$key][$property] = 0;
        }
    }

    /**
     * @param $customerModel
     */
    public function handleBillingAndShipping($customerModel)
    {
        $billingIsSet = false;
        $shippingIsSet = false;


        $addressesToStoreCollection = collect($this->addressesToStore);

        $addressCount = $addressesToStoreCollection->count();
        $cAddresses = $customerModel->addresses()->get();
        $addressesToRemove = $cAddresses->diff($addressesToStoreCollection);
        $addressesToRemove->each(function ($item, $key) {
            Address::where('entity_id', $item->entity_id)->delete();
        });

        if ($addressCount == 1) {
            $customerModel->default_billing = $addressesToStoreCollection->first()->entity_id;
            $customerModel->default_shipping = $addressesToStoreCollection->first()->entity_id;
        } else {
            foreach ($addressesToStoreCollection as $address) {
                if ($address->getDefaultBilling() == 1 && $billingIsSet == false) {
                    $billingIsSet = true;
                    $customerModel->default_billing = $address->entity_id;
                }
                if ($address->getDefaultShipping() == 1 && $shippingIsSet == false) {
                    $shippingIsSet = true;
                    $customerModel->default_shipping = $address->entity_id;
                }
            }
            if (!$billingIsSet) {
                $customerModel->default_billing = $addressesToStoreCollection->first()->entity_id;
            }
            if (!$billingIsSet) {
                $customerModel->default_shipping = $addressesToStoreCollection->first()->entity_id;
            }
        }
        return $customerModel;
    }

    /**
     * @param $customerData
     * @return bool
     */
    public function saveAddresses($customerData)
    {
        if (!isset($customerData['addresses'])) {
            return false;
        }
        foreach ($customerData['addresses']['data'] as $addressesData) {
            foreach ($addressesData as $addressData) {
                $this->collectAddress($addressData);
            }
        }
    }

    /**
     * @param $newConfig
     * @todo replace with array function
     */
    public function config($newConfig)
    {
        if (empty($this->config)) {
            $this->config = $newConfig;
        }
        if ($newConfig) {
            foreach ($this->config as $configKey => $configEntry) {
                if (isset($newConfig[$configKey])) {
                    $this->config[$configKey] = $newConfig[$configKey];
                }
            }
        }
    }
}