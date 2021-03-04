<?php

namespace Billie\Sdk\Model\Request;

/**
 * @method self   setMerchantCustomerId(string $merchantCustomerId)
 * @method string getMerchantCustomerId()
 */
class CreateSessionRequestModel extends AbstractRequestModel
{
    /**
     * @var string
     */
    public $merchantCustomerId;

    public function getFieldValidations()
    {
        return [
            'merchantCustomerId' => 'string',
        ];
    }

    public function toArray()
    {
        return [
            'merchant_customer_id' => $this->merchantCustomerId,
        ];
    }
}
