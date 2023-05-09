<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Service\Request\Invoice;

use Billie\Sdk\Exception\InvalidResponseException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\AbstractRequestModel;
use Billie\Sdk\Model\Request\Invoice\CreateInvoiceRequestModel;
use Billie\Sdk\Model\Response\CreateInvoiceResponseModel;
use Billie\Sdk\Service\Request\AbstractRequest;
use InvalidArgumentException;

/**
 * @see https://docs.billie.io/reference/invoice_create
 * @extends AbstractRequest<CreateInvoiceRequestModel, CreateInvoiceResponseModel>
 */
class CreateInvoiceRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        if ($requestModel instanceof CreateInvoiceRequestModel) {
            return 'invoices';
        }

        throw new InvalidArgumentException('argument must be instance of ' . CreateInvoiceRequestModel::class);
    }

    protected function processSuccess($requestModel, ?array $responseData = null): CreateInvoiceResponseModel
    {
        if ($responseData === null) {
            throw new InvalidResponseException('got no response from gateway. A response was expected.');
        }

        return new CreateInvoiceResponseModel($responseData);
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
