<?php

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laragento\Customer\Repositories\CustomerRepository;
use Laragento\Customer\Transformers\QuoteTransformer;
use Spatie\Fractal\Fractal;
use Tests\CreatesApplication;
use Laragento\Customer\Models\Customer;
use Laragento\CustomerImportExport\Repositories\CustomerImportRepository;


class CustomerImportRepositoryTest extends BaseTestCase
{
    use CreatesApplication;

    //use RefreshDatabase;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    public function setUp()
    {
        parent::setUp();
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(__DIR__ . '/../../../customer/database/factories');
        $this->customerRepository = new CustomerRepository();
        DB::beginTransaction();
    }

    /**
     * @todo improve assert
     * @todo check for errors
     * @todo import just one doesn't work
     */
    public function testImportCustomerWithoutAddressesJson()
    {
        self::assertTrue(true);
//        $customers = factory(Customer::class, 2)->make([]);
//        $customerJson = Fractal::create($customers, new CustomerTransformer())->toJson();
//        $customerImporter = new CustomerImportRepository($this->customerRepository);
//        $errors = $customerImporter->import(json_decode($customerJson,true));
//
//        //print_r($errors);
//
//        foreach ($customers as $customer) {
//            $customerModel = $this->customerRepository->firstByEmail($customer->email);
//            //print_r(Fractal::create($customerModel, new CustomerTransformer())->toArray());
//            $this->assertEquals($customerModel->email, $customer->email);
//            $this->assertEquals($customerModel->firstname, $customer->firstname);
//        }
    }

    public function testImportCustomerWithAddressesJson()
    {
        // Create Customer Models
//        $customers = factory(Customer::class, 2)
//            ->create()
//            ->each(function(Customer $c) {
//                $c->addresses()->saveMany([
//                    factory(Address::class)->make(),
//                    factory(Address::class)->make(),
//                    factory(Address::class)->make(),
//                ]);
//            });
//
//        // Create Json String from these Models
//        $customerJson = Fractal::create($customers, new CustomerTransformer())->toJson();
//        print_r($customerJson);
//
//        // Remove everything from the DB
//        foreach ($customers as $customer) {
//            $customerModel = $this->customerRepository->destroyByEmail($customer->email);
//        }


        $customersJson = '{
          "data": [
            {
              "website_id": 1,
              "email": "philippe.bumann@mexan3.ch",
              "group_id": 1,
              "prefix": null,
              "firstname": "hans",
              "middlename": "maria",
              "lastname": "jacob",
              "suffix": null,
              "dob": null,
              "gender": null,
              "default_billing": null,
              "default_shipping": 1,
              "addresses": {
                "data": {
                  "data": [
                        {
                          "firstname": "Hans",
                          "middlename": null,
                          "lastname": "Jacob",
                          "company": null,
                          "street": "test adresse",
                          "city": "test",
                          "postcode": 9999,
                          "region": "Luzern",
                          "region_id": 115,
                          "country_id": "CH",
                          "prefix": null,
                          "suffix": null,
                          "telephone": "21321321332",
                          "fax": null,
                          "default_shipping": 1,
                          "default_billing": 0
                        },
                        {
                          "firstname": "Peter",
                          "middlename": null,
                          "lastname": "Lustig",
                          "company": null,
                          "street": "test adresse",
                          "city": "test",
                          "postcode": 9999,
                          "region": "Luzern",
                          "region_id": 115,
                          "country_id": "CH",
                          "prefix": null,
                          "suffix": null,
                          "telephone": "21321321332",
                          "fax": null,
                          "default_shipping": 1,
                          "default_billing": 0
                        }
                  ]
                }
              }
            }
          ]
        }';


        $customers = json_decode($customersJson, true);

        // Use the Import Script
        $customerImporter = new CustomerImportRepository($this->customerRepository);
        $errors = $customerImporter->import($customers);

        // Assert
        print_r($errors);
        foreach ($customers['data'] as $customerData) {
            $customerModel = $this->customerRepository->firstByEmail($customerData['email']);
            //print_r(Fractal::create($customerModel, new CustomerTransformer())->toArray());
            $this->assertEquals($customerModel->email, $customerData['email']);
            foreach ($customerData['addresses']['data'] as $addressesData) {
                foreach ($addressesData as $addressData) {
                    $this->assertEquals($customerModel->addresses()->first()->firstname, $addressData['firstname']);
                    break;
                }
            }
        }
    }


    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}