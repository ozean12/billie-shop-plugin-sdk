<?php


namespace Billie\Sdk\Service\Request;


use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\CheckoutSessionConfirmRequestModel;
use InvalidArgumentException;

class CheckoutSessionConfirmRequest extends AbstractRequest
{

    protected function getPath(AbstractRequestModel $requestModel)
    {
        if ($requestModel instanceof CheckoutSessionConfirmRequestModel) {
            return 'checkout-session/' . $requestModel->getSessionUuid() . '/confirm';
        }
        throw new InvalidArgumentException('argument must be instance of ' . CheckoutSessionConfirmRequestModel::class);
    }

    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        return new Order($responseData);
    }

    protected function getMethod(AbstractRequestModel $requestModel)
    {
        return BillieClient::METHOD_PUT;
    }
}