<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\CheckoutSession;

use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Model\Request\CheckoutSession\GetCheckoutAuthorizationRequestModel;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class GetCheckoutAuthorizationRequestModelTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = $this->getValidModel();
        $data = $model->toArray();

        static::assertIsArray($data);
        static::assertCount(0, $data);
    }

    protected function getValidModel(): AbstractModel
    {
        return (new GetCheckoutAuthorizationRequestModel())
            ->setSessionUuid('test-uuid');
    }
}
