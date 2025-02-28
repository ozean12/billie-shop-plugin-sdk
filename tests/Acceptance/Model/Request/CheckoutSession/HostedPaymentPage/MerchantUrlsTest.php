<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Request\CheckoutSession\HostedPaymentPage;

use Billie\Sdk\Model\AbstractModel;
use Billie\Sdk\Model\Request\CheckoutSession\HostedPaymentPage\MerchantUrls;
use Billie\Sdk\Tests\Acceptance\Model\AbstractModelTestCase;

class MerchantUrlsTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $model = $this->getValidModel();
        $data = $model->toArray();

        self::assertArrayHasKey('accept_url', $data);
        self::assertEquals('https://test.local/success', $data['accept_url']);
        self::assertArrayHasKey('decline_url', $data);
        self::assertEquals('https://test.local/fail', $data['decline_url']);
    }

    protected function getValidModel(): AbstractModel
    {
        return (new MerchantUrls())
            ->setAcceptUrl('https://test.local/success')
            ->setDeclineUrl('https://test.local/fail');
    }
}
