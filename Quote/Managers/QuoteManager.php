<?php


namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionItem;
use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\DataObjects\QuoteSessionTotals;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;
use Laragento\SalesRule\DataObjects\RuleInterface;
use Laragento\SalesRule\Repositories\SalesRuleRepositoryInterface;

class QuoteManager implements QuoteManagerInterface
{
    /**
     * @var QuoteSessionObjectRepositoryInterface
     */
    protected $quoteDataRepository;

    /**
     * @var
     */
    protected $quoteItemRepository;

    protected $cartTotals;
    /**
     * @var SalesRuleRepositoryInterface
     */
    protected $salesRuleRepository;
    /**
     * @var RuleInterface
     */
    protected $rule;

    /**
     * QuoteManager constructor.
     * @param QuoteSessionObjectRepositoryInterface $quoteDataRepository
     * @param QuoteSessionTotals $cartTotals
     * @param SalesRuleRepositoryInterface $salesRuleRepository
     */
    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository,
        QuoteSessionTotals $cartTotals,
        SalesRuleRepositoryInterface $salesRuleRepository
    ) {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->cartTotals = $cartTotals;
        $this->salesRuleRepository = $salesRuleRepository;
    }

    /**
     * @return QuoteSessionObject
     */
    public function getQuote()
    {
        return $this->quoteDataRepository->getQuote();
    }

    /**
     * @param QuoteSessionObject $quote
     *
     * - We calculate tax for every product since every product can have different taxation
     * - @todo when above is the case $discountTaxAmount won't be correct anymore
     */
    public function calculateTotals($quote)
    {
        $prices = [];
        $taxes = [
            'total' => 0.0000,
            'base_total' => 0.0000,
        ];
        $totalWeight = 0.0000;

        /**
         * Items
         */
        // ToDo Must become abstracted as TaxRule/Calculation Module
        /** @var QuoteSessionItem $item */
        foreach ($quote->getItems() as $item) {
            array_push($prices, $item->getBaseRowTotalInclTax());
            $baseTax = $item->getBaseRowTotalInclTax() - $item->getBaseRowTotal();
            $tax = ($item->getRowTotalInclTax()) - $item->getRowTotal();
            $strIndex = str_replace('.', '_', number_format($item->getTaxPercent(), 2));
            $val = isset($taxes[$strIndex]) ? $taxes[$strIndex] : 0;
            $taxes[$strIndex] = $val + $tax;
            $item->setRowWeight(($item->getWeight() * $item->getQty()));
            $totalWeight = $totalWeight + ($item->getWeight() * $item->getQty());
            $taxes['base_total'] = $this->formatItemPrices($taxes[$strIndex]);
            $taxes['total'] = $this->convertBaseToQuote($taxes['base_total']);
        }

        /**
         * Shipping
         */
        $shippingPrice = 0.00;
        $shippingTaxAmount = 0.00;

        if (is_object($quote->getShipping())) {
            $shipping = $quote->getShipping();
            if ($shipping->getPrice() != null) {
                $shippingPrice = $shipping->getPrice();
                $shippingTaxAmount = $shippingPrice - ($shippingPrice / ((config('quote.totals.tax_percent') / 100) + 1));
            }
        }

        /**
         * Subtotal
         */
        $baseSubTotalFull = array_sum($prices);
        $baseSubTotal = $this->formatItemPrices($baseSubTotalFull);
        $quote->setSubtotal($this->convertBaseToQuote($baseSubTotal));
        $quote->setBaseSubtotal($baseSubTotal);

        /**
         * Discount
         */
        $discount = $this->getDiscount($quote);
        $discountTaxAmount = $discount - ($discount / ((config('quote.totals.tax_percent') / 100) + 1));
        $baseSubtotalWithDiscount = $baseSubTotal - $discount;
        $quote->setSubtotalWithDiscount($this->convertBaseToQuote($baseSubtotalWithDiscount));
        $quote->setBaseSubtotalWithDiscount($baseSubtotalWithDiscount);


        /**
         * Taxes
         */
        $taxes['base_total'] = $taxes['base_total'] + $shippingTaxAmount - $discountTaxAmount;
        $taxes['total'] = $taxes['total'] + $shippingTaxAmount - $discountTaxAmount;
        $quote->setTaxGroups($taxes);

        /**
         * GrandTotal
         */
        $baseGrandTotalFull = $baseSubtotalWithDiscount + $shippingPrice;
        $baseGrandTotal = $this->formatItemPrices($baseGrandTotalFull);
        $quote->setGrandTotal($this->convertBaseToQuote($baseGrandTotal));
        $quote->setBaseGrandTotal($baseGrandTotal);


        // ToDo if 5Rp round is needed
        //var_dump(round(($var + 0.000001) * 20) / 20,2);

        /**
         * Weight
         */
        $quote->setTotalWeight($totalWeight);


        /**
         * Additional
         */
        $quote = $this->setAdditionalCartInfo($quote, $taxes);

        // Update Quote
        $this->quoteDataRepository->updateQuote($quote);
    }

    public function updateCouponCode($couponCode)
    {
        if (!$couponCode) {
            $this->removeCouponCode();
        }
        /** @var QuoteSessionObject $quote */
        $quote = $this->getQuote();
        $quote->setCouponCode($couponCode);
        if ($this->salesRuleRepository->isCouponValid($quote)) {
            $quote->setCouponCode($couponCode);
            $this->calculateTotals($quote);
            return true;
        }
        $quote->setCouponCode(null);
        return false;
    }

    public function removeCouponCode()
    {
        /** @var QuoteSessionObject $quote */
        $quote = $this->getQuote();
        $quote->setCouponCode(null);
        $this->calculateTotals($quote);
    }

    /**
     * @param QuoteSessionObject $quote
     * @return float
     */
    protected function getDiscount($quote)
    {
        $rules = $this->salesRuleRepository->rules($quote);
        $discount = 0.00;
        /** @var RuleInterface $rule */
        foreach ($rules as $rule) {
            $discount += $rule->discount_amount;
        }
        if ((float)$quote->getBaseSubtotal() < $discount) {
            return 0.00;
        }
        return $discount;
    }

    protected function formatItemPrices($value)
    {
        return roundPrecicePrice($value, 1, 2, 4);
    }

    /**
     * @param $value
     * @return string
     */
    protected function convertBaseToQuote($value): string
    {
        $rate = $this->getQuote()->base_to_quote_rate;
        return $this->formatItemPrices($value * $rate);
    }

    /**
     * @param $quote
     * @return mixed
     */
    public function setAdditionalCartInfo($quote, $taxes)
    {
        $totalTax = $taxes['total'];
        // Totals
        $this->cartTotals->setTaxAmount($totalTax);

        $customAttributes = $quote->getCustomAttributes();
        $customAttributes['totals'] = $this->cartTotals;
        $quote->setCustomAttributes($customAttributes);

        return $quote;
    }

}