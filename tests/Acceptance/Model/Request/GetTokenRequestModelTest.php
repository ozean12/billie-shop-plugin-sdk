<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request;

use Billie\Sdk\Model\Request\GetTokenRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class GetTokenRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new GetTokenRequestModel())
            ->setClientId('client-id')
            ->setClientSecret('client-secret')
            ->toArray();

        static::assertEquals('client_credentials', $data['grant_type']);
        static::assertEquals('client-id', $data['client_id']);
        static::assertEquals('client-secret', $data['client_secret']);
    }
}
