<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model;

use Billie\Sdk\Model\OrderPaymentMethod;
use DateTime;

class OrderPaymentMethodTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        // nothing to test, cause there are no setters
        static::assertTrue(true);
    }

    public function testFromArray(): void
    {
        $model = $this->getValidModel();

        static::assertEquals('bank-transfer', $model->getType());
        static::assertEquals('DE000000012345567', $model->getIban());
        static::assertEquals('ABCDEFGHIJ', $model->getBic());
        static::assertEquals('reference', $model->getMandateReference());
        static::assertInstanceOf(DateTime::class, $model->getMandateExecutionDate());
        static::assertEquals('identifier', $model->getCreditorIdentification());
    }

    protected function getValidModel(): OrderPaymentMethod
    {
        // does not make so much cause the method `getValidModel` is used for testing the `fromArray` method.
        // but the behaviour is tested :)
        return (new OrderPaymentMethod())
            ->fromArray([
                'type' => 'bank-transfer',
                'data' => [
                    'iban' => 'DE000000012345567',
                    'bic' => 'ABCDEFGHIJ',
                    'mandate_reference' => 'reference',
                    'mandate_execution_date' => '2022-01-01 12:13:14',
                    'creditor_identification' => 'identifier',
                ],
            ]);
    }
}
