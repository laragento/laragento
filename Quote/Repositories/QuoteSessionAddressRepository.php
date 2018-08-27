<?php

namespace Laragento\Quote\Repositories;

use Laragento\Quote\DataObjects\QuoteSessionAddress;
use Laragento\Quote\DataObjects\QuoteSessionObject;

class QuoteSessionAddressRepository implements QuoteSessionAddressRepositoryInterface
{
    /**
     * @var QuoteSessionObjectRepositoryInterface
     */
    protected $quoteDataRepository;

    /**
     * QuoteSessionAddressRepository constructor.
     *
     * @param QuoteSessionObjectRepositoryInterface $quoteDataRepository
     */
    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository
    ) {
        $this->quoteDataRepository = $quoteDataRepository;
    }

    /**
     * @inheritdoc
     */
    public function get(): array
    {
        return $this->quote()->getAddresses();
    }

    /**
     * @inheritdoc
     */
    public function byId($id)
    {
        $addresses = $this->get();

        /** @var QuoteSessionAddress $address */
        foreach ($addresses as $address) {
            if ($address->getAddressId() == $id) {
                return $address;
            }
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function create($data)
    {
        // Get and set Address
        // [..]

        // Populate Address
        $quoteAddress = new QuoteSessionAddress();
        foreach ($data as $key => $value) {
            $function = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            $quoteAddress->$function($value);
        }
        return $quoteAddress;
    }

    /**
     * @inheritdoc
     */
    public function update($id, $data): array
    {
        // Find address
        $newAddress = null;
        $addresses = $this->get();
        /** @var QuoteSessionAddress $address */
        foreach ($addresses as $address) {
            if ($address->getAddressId() == $id) {
                $newAddress = $address;
                break;
            }
        }

        // Set new address values
        foreach ($data as $key => $value) {
            $function = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            $newAddress->$function($value);
        }
        return $addresses;
    }

    /**
     * @inheritdoc
     */
    public function destroy($id)
    {
        $addresses = $this->get();
        $index = 0;
        /** @var QuoteSessionAddress $address */
        foreach ($addresses as $address) {
            if ($address->getAddressId() == $id) {
                unset($addresses[$index]);
                break;
            }
            $index++;
        }
        return array_values($addresses);
    }

    /**
     * Get the cart.
     *
     * @return QuoteSessionObject
     */
    protected function quote()
    {
        return $this->quoteDataRepository->getQuote();
    }
}