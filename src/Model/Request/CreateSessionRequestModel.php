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

    /**
     * {@inheritDoc}
     */
    public function getFieldValidations()
    {
        return [
            'merchantCustomerId' => 'string',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return [
            'merchant_customer_id' => $this->merchantCustomerId,
        ];
    }
}
