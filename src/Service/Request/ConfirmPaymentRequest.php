<?php

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\ConfirmPaymentRequestModel;
use InvalidArgumentException;

/**
 * @method bool execute(ConfirmPaymentRequestModel $requestModel)
 */
class ConfirmPaymentRequest extends AbstractRequest
{
    protected function getPath(AbstractRequestModel $requestModel)
    {
        if ($requestModel instanceof ConfirmPaymentRequestModel) {
            return 'order/' . $requestModel->getId() . '/confirm-payment';
        }
        throw new InvalidArgumentException('argument must be instance of ' . ConfirmPaymentRequestModel::class);
    }

    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        return true;
    }

    protected function getMethod(AbstractRequestModel $requestModel)
    {
        return BillieClient::METHOD_POST;
    }
}
