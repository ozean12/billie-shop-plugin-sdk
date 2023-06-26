<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\Auth;

use Billie\Sdk\Model\Request\Auth\GetTokenRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class GetTokenRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = $this->getValidModel()->toArray();

        static::assertEquals('client_credentials', $data['grant_type'] ?? null);
        static::assertEquals('client-id', $data['client_id'] ?? null);
        static::assertEquals('client-secret', $data['client_secret'] ?? null);
    }

    protected function getValidModel(): GetTokenRequestModel
    {
        return (new GetTokenRequestModel())
            ->setClientId('client-id')
            ->setClientSecret('client-secret');
    }
}
