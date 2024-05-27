<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Response;

use Billie\Sdk\Model\Response\BankAccount;
use PHPUnit\Framework\TestCase;

class BankAccountTest extends TestCase
{
    public function testFromArray(): void
    {
        $model = new BankAccount([
            'iban' => 'test-iban',
            'bic' => 'test-bic',
        ]);

        static::assertEquals('test-iban', $model->getIban());
        static::assertEquals('test-bic', $model->getBic());
    }
}
