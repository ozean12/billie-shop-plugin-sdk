<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\ConfirmPaymentRequestModel;
use InvalidArgumentException;

/**
 * @see https://developers.billie.io/#operation/order_payment_confirm
 *
 * @method bool execute(ConfirmPaymentRequestModel $requestModel)
 */
class ConfirmPaymentRequest extends AbstractRequest
{
    protected function getPath(AbstractRequestModel $requestModel): string
    {
        if ($requestModel instanceof ConfirmPaymentRequestModel) {
            return 'order/' . $requestModel->getId() . '/confirm-payment';
        }

        throw new InvalidArgumentException('argument must be instance of ' . ConfirmPaymentRequestModel::class);
    }

    protected function getMethod(AbstractRequestModel $requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
