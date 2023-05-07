<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request;

use Billie\Sdk\Util\ValidationConstants;

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
            'merchantCustomerId' => ValidationConstants::TYPE_STRING_REQUIRED,
        ];
    }

    public function toArray(): array
    {
        return [
            'merchant_customer_id' => $this->merchantCustomerId,
        ];
    }
}
