<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Tests\Functional\Service\Request;

use Billie\Sdk\Exception\BillieException;
use Billie\Sdk\Model\Request\OrderRequestModel;
use Billie\Sdk\Service\Request\Order\CancelOrderRequest;
use Billie\Sdk\Tests\AbstractTestCase;
use Billie\Sdk\Tests\Helper\BillieClientHelper;

abstract class AbstractOrderRequest extends AbstractTestCase
{
    /**
     * @var string[]
     */
    protected array $orderIds = [];

    protected function tearDown(): void
    {
        try {
            $service = (new CancelOrderRequest(BillieClientHelper::getClient()));
            foreach ($this->orderIds as $orderId) {
                $service->execute(new OrderRequestModel($orderId));
            }
        } catch (BillieException $billieException) {
        }
    }
}
