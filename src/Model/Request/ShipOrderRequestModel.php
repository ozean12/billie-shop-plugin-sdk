<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model\Request;

/**
 * @method string|null getInvoiceUrl()
 * @method self        setInvoiceUrl(?string $invoiceNumber)
 * @method string|null getShippingDocumentUrl()
 * @method self        setShippingDocumentUrl(?string $shippingDocumentUrl)
 * @method string|null getExternalOrderId()
 * @method self        setExternalOrderId(?string $externalOrderId)
 * @method string      getInvoiceNumber()
 * @method self        setInvoiceNumber(string $invoiceNumber)
 */
class ShipOrderRequestModel extends OrderRequestModel
{
    protected ?string $invoiceUrl = null;

    protected ?string  $shippingDocumentUrl = null;

    protected ?string $externalOrderId = null;

    protected ?string $invoiceNumber = null;

    protected function getFieldValidations(): array
    {
        return array_merge(parent::getFieldValidations(), [
            //            'invoiceUrl' => 'url',
            //            'shippingDocumentUrl' => '?url',
            // The gateway accepts any string
            'invoiceUrl' => '?string',
            'shippingDocumentUrl' => '?string',
            'externalOrderId' => '?string',
            'invoiceNumber' => 'string',
        ]);
    }

    protected function _toArray(): array
    {
        return array_merge(parent::_toArray(), [
            'invoice_url' => $this->getInvoiceUrl(),
            'shipping_document_url' => $this->getShippingDocumentUrl(),
            'external_order_id' => $this->getExternalOrderId(),
            'invoice_number' => $this->getInvoiceNumber(),
        ]);
    }
}
