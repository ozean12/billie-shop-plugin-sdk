<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\CheckoutSession;

use Billie\Sdk\Model\Request\CheckoutSession\CreateSessionRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CreateSessionRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = $this->getValidModel()->toArray();

        static::assertEquals('123456789', $data['merchant_customer_id'] ?? null);
    }

    protected function getValidModel(): CreateSessionRequestModel
    {
        return (new CreateSessionRequestModel())
            ->setMerchantCustomerId('123456789');
    }
}
