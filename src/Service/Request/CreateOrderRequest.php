<?php


namespace Billie\Sdk\Service\Request;


use Billie\Sdk\Exception\OrderDecline\DebtorLimitExceededException;
use Billie\Sdk\Exception\OrderDecline\DebtorNotIdentifiedException;
use Billie\Sdk\Exception\OrderDecline\InvalidDebtorAddressException;
use Billie\Sdk\Exception\OrderDecline\OrderDeclinedException;
use Billie\Sdk\Exception\OrderDecline\RiskPolicyDeclinedException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Order;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\CreateOrderRequestModel;

/**
 * @link https://developers.billie.io/#tag/Back-end-Order-Creation
 *
 * @method Order execute(CreateOrderRequestModel $requestModel)
 */
class CreateOrderRequest extends AbstractRequest
{
    protected function getMethod(AbstractRequestModel $requestModel)
    {
        return BillieClient::METHOD_POST;
    }

    protected function getPath(AbstractRequestModel $requestModel)
    {
        return '/order';
    }

    /**
     * @param AbstractRequestModel $requestModel
     * @param array|null $responseData
     * @return Order
     * @throws OrderDeclinedException
     */
    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        $model = new Order($responseData);
        if ($requestModel instanceof CreateOrderRequestModel && $model->getDeclineReason()) {
            switch ($model->getDeclineReason()) {
                case Order::DECLINED_REASON_INVALID_ADDRESS:
                    $exception = new InvalidDebtorAddressException($requestModel, $model);
                    break;
                case Order::DECLINED_REASON_DEBTOR_NOT_IDENTIFIED:
                    $exception = new DebtorNotIdentifiedException($requestModel, $model);
                    break;
                case Order::DECLINED_REASON_RISK_POLICY:
                    $exception = new RiskPolicyDeclinedException($requestModel, $model);
                    break;
                case Order::DECLINED_REASON_DEBTOR_LIMIT_EXCEEDED:
                    $exception = new DebtorLimitExceededException($requestModel, $model);
                    break;
                default:
                    $exception = new OrderDeclinedException($requestModel, $model, 'Unknown rejection', strtoupper($model->getDeclineReason()));
                    break;
            }
            $this->processFailed($requestModel, $exception);
            throw $exception;
        }
        return $model;
    }
}