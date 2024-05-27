<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\CheckoutSession;

use Billie\Sdk\Service\Request\CheckoutSession\GetCheckoutAuthorizationRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractRequestTest;

class GetCheckoutAuthorizationRequestTest extends AbstractRequestTest
{
    // request service class is not testable because there is an interaction via browser required before this service can be requested.
    // just adding this Test-Case for abstract testing of the request-service

    protected function getRequestServiceClass(): string
    {
        return GetCheckoutAuthorizationRequest::class;
    }
}
