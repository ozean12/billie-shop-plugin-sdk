<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

use Billie\Sdk\Util\Validation;

/**
 * @method self setReturnShippingCompany(string $returnShippingCompany)
 * @method string|null getReturnShippingCompany()
 * @method self setReturnTrackingNumber(string $returnTrackingNumber)
 * @method string|null getReturnTrackingNumber()
 * @method self setReturnTrackingUrl(string $returnTrackingUrl)
 * @method string|null getReturnTrackingUrl()
 * @method self setShippingCompany(string $shippingCompany)
 * @method string|null getShippingCompany()
 * @method self setShippingMethod(string $shippingMethod)
 * @method string|null getShippingMethod()
 * @method self setShippingTrackingNumber(string $shippingTrackingNumber)
 * @method string|null getShippingTrackingNumber()
 * @method self setShippingTrackingUrl(string $shippingTrackingUrl)
 * @method string|null getShippingTrackingUrl()
 */
class ShippingInformation extends AbstractModel
{
    protected static array $_additionalFieldMapping = [
        'shippingTrackingNumber' => 'tracking_number',
        'shippingTrackingUrl' => 'tracking_url',
    ];

    protected ?string $returnShippingCompany = null;

    protected ?string $returnTrackingNumber = null;

    protected ?string $returnTrackingUrl = null;

    protected ?string $shippingCompany = null;

    protected ?string $shippingMethod = null;

    protected ?string $shippingTrackingNumber = null;

    protected ?string $shippingTrackingUrl = null;

    protected function getFieldValidations(): array
    {
        return [
            'returnTrackingUrl' => Validation::TYPE_URL_OPTIONAL,
            'shippingTrackingUrl' => Validation::TYPE_URL_OPTIONAL,
        ];
    }
}
