<?php

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
        return 'order/' . $requestModel->getId() . '/confirm-payment';
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
