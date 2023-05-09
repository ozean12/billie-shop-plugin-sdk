<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request;

use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class OrderRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = new OrderRequestModel('uuid');
        static::assertCount(0, $data->toArray());
        static::assertEquals('uuid', $data->getId());

        $data->setId('uuid-2');
        static::assertCount(0, $data->toArray());
        static::assertEquals('uuid-2', $data->getId());
    }
}
