<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model;

use Billie\Sdk\Model\ShippingInformation;

class ShippingInformationTest extends AbstractModelTestCase
{
    public function testToArray(): void
    {
        $data = (new ShippingInformation())
            ->setReturnShippingCompany('return-shipping-company')
            ->setReturnTrackingNumber('return-tracking-number')
            ->setReturnTrackingUrl('https://return-tracking-url.com/abc-def-ghi')
            ->setShippingCompany('shipping-company')
            ->setShippingMethod('shipping-method')
            ->setShippingTrackingNumber('shipping-tracking-number')
            ->setShippingTrackingUrl('https://tracking-url.com/abc-def-ghi')
            ->toArray();

        static::assertIsArray($data);
        static::assertCount(7, $data);
        static::assertEquals('return-shipping-company', $data['return_shipping_company']);
        static::assertEquals('return-tracking-number', $data['return_tracking_number']);
        static::assertEquals('https://return-tracking-url.com/abc-def-ghi', $data['return_tracking_url']);
        static::assertEquals('shipping-company', $data['shipping_company']);
        static::assertEquals('shipping-method', $data['shipping_method']);
        static::assertEquals('shipping-tracking-number', $data['tracking_number']);
        static::assertEquals('https://tracking-url.com/abc-def-ghi', $data['tracking_url']);
    }
}
