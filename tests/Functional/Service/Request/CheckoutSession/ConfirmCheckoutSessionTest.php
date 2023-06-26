<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request\CheckoutSession;

use Billie\Sdk\Model\Request\CheckoutSession\CheckoutSessionConfirmRequestModel;
use Billie\Sdk\Service\Request\CheckoutSession\CheckoutSessionConfirmRequest;
use Billie\Sdk\Tests\Functional\Service\Request\AbstractRequestServiceTestCase;

class ConfirmCheckoutSessionTest extends AbstractRequestServiceTestCase
{
    // request service class is not testable cause, there is an interaction via browser required before this service can be requested.
    // just adding this Test-Case for abstract testing of the request-service

    public function getValidEmptyRequestModelClass(): string
    {
        return CheckoutSessionConfirmRequestModel::class;
    }

    protected function getRequestServiceClass(): string
    {
        return CheckoutSessionConfirmRequest::class;
    }
}
