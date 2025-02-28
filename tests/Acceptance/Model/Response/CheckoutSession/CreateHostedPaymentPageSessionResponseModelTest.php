<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Acceptance\Model\Response\CheckoutSession;

use Billie\Sdk\Model\Response\CreateHostedPaymentPageSessionResponseModel;
use DateTime;
use PHPUnit\Framework\TestCase;

class CreateHostedPaymentPageSessionResponseModelTest extends TestCase
{
    public function testFromArray(): void
    {
        $model = new CreateHostedPaymentPageSessionResponseModel([
            'session_id' => 'test-id',
            'expires_at' => '2024-05-29T19:23:45+00:00',
            'hpp_url' => 'test-url',
        ]);

        self::assertEquals('test-id', $model->getSessionId());
        self::assertEquals('test-url', $model->getHppUrl());
        self::assertInstanceOf(DateTime::class, $model->getExpiresAt());
    }
}
