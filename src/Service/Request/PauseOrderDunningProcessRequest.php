<?php

declare(strict_types=1);

namespace Billie\Sdk\Service\Request;

use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\PauseOrderDunningProcessRequestModel;
use InvalidArgumentException;

/**
 * @see https://developers.billie.io/#operation/order_pause_dunning
 *
 * @method bool execute(PauseOrderDunningProcessRequestModel $requestModel)
 */
class PauseOrderDunningProcessRequest extends AbstractRequest
{
    protected function getPath(AbstractRequestModel $requestModel): string
    {
        if ($requestModel instanceof PauseOrderDunningProcessRequestModel) {
            return 'order/' . $requestModel->getId() . '/pause-dunning';
        }

        throw new InvalidArgumentException('argument must be instance of ' . PauseOrderDunningProcessRequestModel::class);
    }

    protected function getMethod(AbstractRequestModel $requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
