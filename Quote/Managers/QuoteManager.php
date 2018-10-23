<?php


namespace Laragento\Quote\Managers;

use Laragento\Quote\DataObjects\QuoteSessionItem;
use Laragento\Quote\DataObjects\QuoteSessionObject;
use Laragento\Quote\DataObjects\QuoteSessionTotals;
use Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface;
use Laragento\SalesRule\DataObjects\RuleInterface;

class QuoteManager
{
    protected $quoteDataRepository;
    protected $quoteItemRepository;
    protected $cartTotals;
    protected $salesRuleRepository;

    /**
     * QuoteManager constructor.
     * @param QuoteSessionObjectRepositoryInterface $quoteDataRepository
     * @param QuoteSessionTotals $cartTotals
     */
    public function __construct(
        QuoteSessionObjectRepositoryInterface $quoteDataRepository,
        QuoteSessionTotals $cartTotals
    ) {
        $this->quoteDataRepository = $quoteDataRepository;
        $this->cartTotals = $cartTotals;
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
     */
    public function calculateTotals($quote)
    {
        $prices = [];
        $taxes = [
            'total' => 0.0000,
            'base_total' => 0.0000,
        ];
        $totalWeight = 0.0000;

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
            $totalWeight = $totalWeight + ($item->getWeight()*$item->getQty());
            $taxes['base_total'] = $this->formatItemPrices($taxes[$strIndex]);
            $taxes['total'] = $this->convertBaseToQuote($taxes['base_total']);
        }

        // Shipping
        if(is_object($quote->getShipping())){
            $shipping = $quote->getShipping();
            $shippingPrice = $shipping->getPrice();
            $shippingTaxAmount = $shippingPrice - ($shippingPrice / ((config('quote.totals.tax_percent') / 100) + 1));
        }else{
            $shippingPrice = 0.00;
            $shippingTaxAmount = 0.00;
        }
        $taxes['base_total'] = $taxes['base_total'] + $shippingTaxAmount;
        $taxes['total'] = $taxes['total'] + $shippingTaxAmount;

        // Grand and Subtotal
        $baseSubTotalFull = array_sum($prices);
        $baseGrandTotalFull = $baseSubTotalFull + $shippingPrice;

        $baseGrandTotal = $this->formatItemPrices($baseGrandTotalFull);
        $baseSubTotal = $this->formatItemPrices($baseSubTotalFull);

        // Discount
        $discount = $this->getDiscount($quote);
        $baseSubtotalWithDiscount = $baseSubTotal - $discount;


        // ToDo if 5Rp round is needed
        //var_dump(round(($var + 0.000001) * 20) / 20,2);

        $quote->setGrandTotal($this->convertBaseToQuote($baseGrandTotal));
        $quote->setBaseGrandTotal($baseGrandTotal);
        $quote->setSubtotal($this->convertBaseToQuote($baseSubTotal));
        $quote->setBaseSubtotal($baseSubTotal);
        $quote->setSubtotalWithDiscount($this->convertBaseToQuote($baseSubtotalWithDiscount));
        $quote->setBaseSubtotalWithDiscount($baseSubtotalWithDiscount);
        $quote->setTaxGroups($taxes);
        $quote->setTotalWeight($totalWeight);

        $quote = $this->setAdditionalCartInfo($quote,$taxes);
        $this->quoteDataRepository->updateQuote($quote);
    }

    protected function getDiscount($quote)
    {
//        $rules = $this->salesRuleRepository->rules($quote);
//        /** @var RuleInterface $rule */
//        foreach ($rules as $rule){
//            return $rule->discount_amount;
//        }
        return 0.0;
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
    public function setAdditionalCartInfo($quote,$taxes)
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