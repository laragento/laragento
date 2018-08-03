<?php


namespace Laragento\Quote\Managers;


use Laragento\Quote\DataObjects\QuoteSessionAddress;
use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\Repositories\QuoteSessionAddressRepositoryInterface;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;

class QuoteAddressManager
{
    protected $quoteDataRepository;
    protected $quoteAddressRepository;

    /**
     * QuoteAddressManager constructor.
     * @param QuoteSessionObjectRepositoryInterface $quoteDataRepository
     * @param QuoteSessionAddressRepositoryInterface $quoteAddressRepository
     */
    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository,
        QuoteSessionAddressRepositoryInterface $quoteAddressRepository
    ) {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->quoteAddressRepository = $quoteAddressRepository;
    }

    /**
     * @return QuoteSessionObject
     */
    public function getQuote()
    {
        return $this->quoteDataRepository->getQuote();
    }

    /**
     * @param $data
     * @param null $address
     */
    public function storeAddresses($data, $address = null): void
    {
        $data = $this->storeAddressData($data, $address);
        $quote = $this->getQuote();
        $quote->setAddresses($data);
    }

    /**
     * @param $addresses
     */
    public function updateAddresses($addresses): void
    {
        $quote = $this->getQuote();
        $quote->setAddresses($addresses);
    }

    /**
     * @param $data
     * @param $address
     * @return array
     */
    public function storeAddressData($data, $address)
    {
        /** @var QuoteSessionAddress $address */
        if (!$address) {
            $addresses = $this->getQuote()->getAddresses();
            if (count($data) > 0) {
                // Set Create new Address
                $addressData = $this->setAddressId($data);
                $address = $this->quoteAddressRepository->createAddress($addressData);
                // Store address
                array_push($addresses, $address);
            }
        } else {
            // Update Address Data
            $addresses = $this->quoteAddressRepository->updateAddress($address->getAddressId(), $data);
        }

        return $addresses;
    }

}