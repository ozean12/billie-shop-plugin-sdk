<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request\CheckoutSession\HostedPaymentPage;

use Billie\Sdk\Model\Request\AbstractRequestModel;

/**
 * @method $this setAcceptUrl(string $acceptUrl)
 * @method string getAcceptUrl()
 * @method $this setDeclineUrl(string $declineUrl)
 * @method string getDeclineUrl()
 */
class MerchantUrls extends AbstractRequestModel
{
    protected string $acceptUrl;

    protected string $declineUrl;

    protected function _toArray(): array
    {
        return [
            'accept_url' => $this->acceptUrl,
            'decline_url' => $this->declineUrl,
        ];
    }
}
