<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\Invoice\CreateInvoice;

use Billie\Sdk\Model\Request\Invoice\CreateInvoice\LineItem;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class LineitemTest extends AbstractModelTestCase
{
    public function testToConstructor(): void
    {
        $data = (new LineItem('123456789', 12))
            ->toArray();

        static::assertIsArray($data);
        static::assertEquals('123456789', $data['external_id']);
        static::assertEquals(12, $data['quantity']);
    }

    public function testToArray(): void
    {
        $data = (new LineItem('123456789', 12))
            ->setExternalId('987654321')
            ->setQuantity(5)
            ->toArray();

        static::assertIsArray($data);
        static::assertEquals('987654321', $data['external_id']);
        static::assertEquals(5, $data['quantity']);
    }
}
