<?php

declare(strict_types=1);

namespace Billie\Sdk\Model\Request;

/**
 * @method self   setMerchantCustomerId(string $merchantCustomerId)
 * @method string getMerchantCustomerId()
 */
class CreateSessionRequestModel extends AbstractRequestModel
{
    public ?string $merchantCustomerId = null;

    public function getFieldValidations(): array
    {
        return [
            'merchantCustomerId' => 'string',
        ];
    }

    public function toArray(): array
    {
        return [
            'merchant_customer_id' => $this->merchantCustomerId,
        ];
    }
}
