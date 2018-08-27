<?php


namespace Laragento\Quote\DataObjects;


/**
 * Class QuoteSessionPayment
 * @package Laragento\Quote\DataObjects
 * @property string method
 */

class QuoteSessionPayment
{

    protected $payment_id;
    protected $quote_id;
    protected $method;


    protected $cc_type;
    protected $cc_number_enc;
    protected $cc_last_4;
    protected $cc_cid_enc;
    protected $cc_owner;
    protected $cc_exp_year;
    protected $cc_ss_owner;
    protected $cc_exp_month;
    protected $cc_ss_start_month;
    protected $cc_sss_start_year;
    protected $po_number;
    protected $additional_data;
    protected $cc_ss_issue;
    protected $additional_information;
    protected $paypal_payer_id;
    protected $paypal_payer_status;
    protected $paypal_correlation_id;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getPaymentId()
    {
        return $this->payment_id;
    }

    /**
     * @param mixed $payment_id
     */
    public function setPaymentId($payment_id)
    {
        $this->payment_id = $payment_id;
    }

    /**
     * @return mixed
     */
    public function getQuoteId()
    {
        return $this->quote_id;
    }

    /**
     * @param mixed $quote_id
     */
    public function setQuoteId($quote_id)
    {
        $this->quote_id = $quote_id;
    }

    /**
     * @return mixed
     */
    public function getCcType()
    {
        return $this->cc_type;
    }

    /**
     * @param mixed $cc_type
     */
    public function setCcType($cc_type): void
    {
        $this->cc_type = $cc_type;
    }

    /**
     * @return mixed
     */
    public function getCcNumberEnc()
    {
        return $this->cc_number_enc;
    }

    /**
     * @param mixed $cc_number_enc
     */
    public function setCcNumberEnc($cc_number_enc): void
    {
        $this->cc_number_enc = $cc_number_enc;
    }

    /**
     * @return mixed
     */
    public function getCcLast4()
    {
        return $this->cc_last_4;
    }

    /**
     * @param mixed $cc_last_4
     */
    public function setCcLast4($cc_last_4): void
    {
        $this->cc_last_4 = $cc_last_4;
    }

    /**
     * @return mixed
     */
    public function getCcCidEnc()
    {
        return $this->cc_cid_enc;
    }

    /**
     * @param mixed $cc_cid_enc
     */
    public function setCcCidEnc($cc_cid_enc): void
    {
        $this->cc_cid_enc = $cc_cid_enc;
    }

    /**
     * @return mixed
     */
    public function getCcOwner()
    {
        return $this->cc_owner;
    }

    /**
     * @param mixed $cc_owner
     */
    public function setCcOwner($cc_owner): void
    {
        $this->cc_owner = $cc_owner;
    }

    /**
     * @return mixed
     */
    public function getCcExpYear()
    {
        return $this->cc_exp_year;
    }

    /**
     * @param mixed $cc_exp_year
     */
    public function setCcExpYear($cc_exp_year): void
    {
        $this->cc_exp_year = $cc_exp_year;
    }

    /**
     * @return mixed
     */
    public function getCcSsOwner()
    {
        return $this->cc_ss_owner;
    }

    /**
     * @param mixed $cc_ss_owner
     */
    public function setCcSsOwner($cc_ss_owner): void
    {
        $this->cc_ss_owner = $cc_ss_owner;
    }

    /**
     * @return mixed
     */
    public function getCcExpMonth()
    {
        return $this->cc_exp_month;
    }

    /**
     * @param mixed $cc_exp_month
     */
    public function setCcExpMonth($cc_exp_month): void
    {
        $this->cc_exp_month = $cc_exp_month;
    }

    /**
     * @return mixed
     */
    public function getCcSsStartMonth()
    {
        return $this->cc_ss_start_month;
    }

    /**
     * @param mixed $cc_ss_start_month
     */
    public function setCcSsStartMonth($cc_ss_start_month): void
    {
        $this->cc_ss_start_month = $cc_ss_start_month;
    }

    /**
     * @return mixed
     */
    public function getCcSssStartYear()
    {
        return $this->cc_sss_start_year;
    }

    /**
     * @param mixed $cc_sss_start_year
     */
    public function setCcSssStartYear($cc_sss_start_year): void
    {
        $this->cc_sss_start_year = $cc_sss_start_year;
    }

    /**
     * @return mixed
     */
    public function getPoNumber()
    {
        return $this->po_number;
    }

    /**
     * @param mixed $po_number
     */
    public function setPoNumber($po_number): void
    {
        $this->po_number = $po_number;
    }

    /**
     * @return mixed
     */
    public function getAdditionalData()
    {
        return $this->additional_data;
    }

    /**
     * @param mixed $additional_data
     */
    public function setAdditionalData($additional_data): void
    {
        $this->additional_data = $additional_data;
    }

    /**
     * @return mixed
     */
    public function getCcSsIssue()
    {
        return $this->cc_ss_issue;
    }

    /**
     * @param mixed $cc_ss_issue
     */
    public function setCcSsIssue($cc_ss_issue): void
    {
        $this->cc_ss_issue = $cc_ss_issue;
    }

    /**
     * @return mixed
     */
    public function getAdditionalInformation()
    {
        return $this->additional_information;
    }

    /**
     * @param mixed $additional_information
     */
    public function setAdditionalInformation($additional_information): void
    {
        $this->additional_information = $additional_information;
    }

    /**
     * @return mixed
     */
    public function getPaypalPayerId()
    {
        return $this->paypal_payer_id;
    }

    /**
     * @param mixed $paypal_payer_id
     */
    public function setPaypalPayerId($paypal_payer_id): void
    {
        $this->paypal_payer_id = $paypal_payer_id;
    }

    /**
     * @return mixed
     */
    public function getPaypalPayerStatus()
    {
        return $this->paypal_payer_status;
    }

    /**
     * @param mixed $paypal_payer_status
     */
    public function setPaypalPayerStatus($paypal_payer_status): void
    {
        $this->paypal_payer_status = $paypal_payer_status;
    }

    /**
     * @return mixed
     */
    public function getPaypalCorrelationId()
    {
        return $this->paypal_correlation_id;
    }

    /**
     * @param mixed $paypal_correlation_id
     */
    public function setPaypalCorrelationId($paypal_correlation_id): void
    {
        $this->paypal_correlation_id = $paypal_correlation_id;
    }

    /**
     * @return array
     */
    public function getCustomAttributes(): array
    {
        return $this->customAttributes;
    }

    /**
     * @param array $customAttributes
     */
    public function setCustomAttributes(array $customAttributes): void
    {
        $this->customAttributes = $customAttributes;
    }


    // Object only
    protected $customAttributes = [];

    public function __get($prop)
    {
        return $this->$prop;
    }

    public function __isset($prop) : bool
    {
        return isset($this->$prop);
    }

    public function toArray()
    {
        $serialized = (array)$this;
        $search = "\x00*\x00";
        $replacedKeys = str_replace($search, '', array_keys($serialized));

        return array_combine($replacedKeys, $serialized);

    }


}

