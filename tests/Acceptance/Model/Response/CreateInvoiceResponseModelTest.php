<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Response;

use Billie\Sdk\Model\Response\CreateInvoiceResponseModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CreateInvoiceResponseModelTest extends AbstractModelTestCase
{
    public function testFromArray(): void
    {
        $responseModel = new CreateInvoiceResponseModel([
            'uuid' => '12345678',
        ]);

        static::assertEquals('12345678', $responseModel->getUuid());
    }
}
