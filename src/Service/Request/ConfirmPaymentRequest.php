<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\ConfirmPaymentRequestModel;

/**
 * @see https://developers.billie.io/#operation/order_payment_confirm
 *
 * @extends AbstractRequest<ConfirmPaymentRequestModel, bool>
 */
class ConfirmPaymentRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'order/' . $requestModel->getUuid() . '/confirm-payment';
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
