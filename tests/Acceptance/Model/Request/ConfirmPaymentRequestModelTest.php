<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request;

use Billie\Sdk\Model\Request\ConfirmPaymentRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class ConfirmPaymentRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new ConfirmPaymentRequestModel('uuid'))
            ->setPaidAmount(100.50)
            ->toArray();

        static::assertCount(1, $data); // session-uuid should not be in the data array
        static::assertEquals(100.50, $data['paid_amount']);
    }
}
