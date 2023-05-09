<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request;

/**
 * @method self   setMerchantCustomerId(string $merchantCustomerId)
 * @method string getMerchantCustomerId()
 */
class CreateSessionRequestModel extends AbstractRequestModel
{
    public string $merchantCustomerId;

    protected function _toArray(): array
    {
        return [
            'merchant_customer_id' => $this->merchantCustomerId,
        ];
    }
}
