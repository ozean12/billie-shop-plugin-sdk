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
        $model = $this->getValidModel();
        $data = $model->toArray();

        static::assertIsArray($data);
        static::assertCount(4, $data); // uuid is a path-parameter, so it will not send via body
        static::assertEquals('invoice-uuid', $model->getUuid());
        static::assertEquals('external-code', $data['external_code'] ?? null);
        static::assertIsArray($data['amount'] ?? null);
        static::assertIsArray($data['line_items'] ?? null);
        static::assertCount(2, $data['line_items']);
        static::assertEquals('my-comment', $data['comment'] ?? null);
    }

    public function testAddItems(): void
    {
        $model = $this->getValidModel();
        $model->disableValidateOnSet();

        // reset array
        $model->setLineItems([]);
        $model->addLineItem(new LineItem('test', 1));
        $model->addLineItem(new LineItem('test', 1));
        static::assertIsArray($model->getLineItems());
        static::assertCount(2, $model->getLineItems());

        $model->addLineItem(new LineItem('test', 1));
        static::assertCount(3, $model->getLineItems());
    }

    protected function getValidModel(): CreateCreditNoteRequestModel
    {
        return (new CreateCreditNoteRequestModel('invoice-uuid', 'external-code'))
            ->setAmount(self::createModelMock(Amount::class))
            ->setComment('my-comment')
            ->setLineItems([
                self::createModelMock(LineItem::class),
                self::createModelMock(LineItem::class),
            ]);
    }
}
