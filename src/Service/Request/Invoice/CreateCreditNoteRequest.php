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
use Billie\Sdk\Exception\InvoiceNotFoundException;
use Billie\Sdk\HttpClient\BillieClient;
use Billie\Sdk\Model\Request\Invoice\CreateCreditNoteRequestModel;
use Billie\Sdk\Model\Response\CreateCreditNoteResponseModel;
use Billie\Sdk\Service\Request\AbstractRequest;

/**
 * @see https://docs.billie.io/reference/create_credit_note
 * @extends AbstractRequest<CreateCreditNoteRequestModel, CreateCreditNoteResponseModel>
 */
class CreateCreditNoteRequest extends AbstractRequest
{
    protected function getPath($requestModel): string
    {
        return 'invoices/' . $requestModel->getUuid() . '/credit-notes';
    }

    protected function processSuccess($requestModel, ?array $responseData = null): CreateCreditNoteResponseModel
    {
        if ($responseData === null) {
            throw new InvalidResponseException('got no response from gateway. A response was expected.');
        }

        return new CreateCreditNoteResponseModel($responseData);
    }

    protected function getNotFoundExceptionClass(): ?string
    {
        return InvoiceNotFoundException::class;
    }

    protected function getMethod($requestModel): string
    {
        return BillieClient::METHOD_POST;
    }
}
