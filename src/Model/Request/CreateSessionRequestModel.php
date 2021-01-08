<?php

namespace Billie\Sdk\Model\Request;

/**
 * @method self setMerchantCustomerId(string $merchantCustomerId)
 * @method string getMerchantCustomerId()
 */
class CreateSessionRequestModel extends AbstractRequestModel
{
    /**
     * @var string
     */
    public $merchantCustomerId;

    /**
     * @param string $merchantCustomerId
     */
    public function __construct($merchantCustomerId)
    {
        $this->merchantCustomerId = $merchantCustomerId;
    }

    public function getFieldValidations()
    {
        return [
            'merchantCustomerId' => 'string'
        ];
    }

    public function toArray()
    {
        return [
            'merchant_customer_id' => $this->merchantCustomerId
        ];
    }
}
