<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\Invoice;

use Billie\Sdk\Model\Request\Invoice\UpdateInvoiceRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class UpdateInvoiceRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new UpdateInvoiceRequestModel('uuid'))
            ->setInvoiceNumber('invoice-number')
            ->setInvoiceUrl('invoice-url');

        $data = $model->toArray();
        static::assertIsArray($data);
        static::assertCount(2, $data);
        static::assertEquals('invoice-number', $data['external_code']);
        static::assertEquals('invoice-url', $data['invoice_url']);

        $model->setUuid('uuid-2');
        $data = $model->toArray();
        static::assertIsArray($data);
        static::assertCount(2, $data);
        static::assertEquals('invoice-number', $data['external_code']);
        static::assertEquals('invoice-url', $data['invoice_url']);
    }
}
