<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\Invoice;

use Billie\Sdk\Model\Amount;
use Billie\Sdk\Model\Request\Invoice\CreateCreditNoteRequestModel;
use Billie\Sdk\Model\Request\Invoice\LineItem;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class CreateCreditNoteRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = (new CreateCreditNoteRequestModel('invoice-uuid', 'external-code'))
            ->setAmount(self::createMock(Amount::class))
            ->setComment('my-comment')
            ->setLineItems([
                self::createMock(LineItem::class),
                self::createMock(LineItem::class),
            ]);
        $data = $model->toArray();

        static::assertIsArray($data);
        static::assertCount(4, $data); // uuid is a path-parameter, so it will not send via body
        static::assertEquals('invoice-uuid', $model->getUuid());
        static::assertEquals('external-code', $data['external_code']);
        static::assertIsArray($data['amount']);
        static::assertIsArray($data['line_items']);
        static::assertCount(2, $data['line_items']);
        static::assertEquals('my-comment', $data['comment']);
    }
}
