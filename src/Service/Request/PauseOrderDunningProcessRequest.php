<?php

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\PauseOrderDunningProcessRequestModel;
use InvalidArgumentException;

/**
 * @method bool execute(PauseOrderDunningProcessRequestModel $requestModel)
 */
class PauseOrderDunningProcessRequest extends AbstractRequest
{
    protected function getPath(AbstractRequestModel $requestModel)
    {
        if ($requestModel instanceof PauseOrderDunningProcessRequestModel) {
            return 'order/' . $requestModel->getId() . '/pause-dunning';
        }
        throw new InvalidArgumentException('argument must be instance of ' . PauseOrderDunningProcessRequestModel::class);
    }

    protected function processSuccess(AbstractRequestModel $requestModel, $responseData)
    {
        // there is only a HTTP Code 204 response
        return true;
    }

    protected function getMethod(AbstractRequestModel $requestModel)
    {
        return BillieClient::METHOD_POST;
    }
}
