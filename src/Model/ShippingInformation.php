<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

use Billie\Sdk\Util\ResponseHelper;
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
    protected ?string $returnShippingCompany = null;

    protected ?string $returnTrackingNumber = null;

    protected ?string $returnTrackingUrl = null;

    protected ?string $shippingCompany = null;

    protected ?string $shippingMethod = null;

    protected ?string $shippingTrackingNumber = null;

    protected ?string $shippingTrackingUrl = null;

    /**
     * @internal currently the model is not part of any response. we added this method just for completion in case of that any response will enrich with shipping information
     */
    public function fromArray(array $data): AbstractModel
    {
        $this->returnShippingCompany = ResponseHelper::getString($data, 'return_shipping_company');
        $this->returnTrackingNumber = ResponseHelper::getString($data, 'return_tracking_number');
        $this->returnTrackingUrl = ResponseHelper::getString($data, 'return_tracking_url');
        $this->shippingCompany = ResponseHelper::getString($data, 'shipping_company');
        $this->shippingMethod = ResponseHelper::getString($data, 'shipping_method');
        $this->shippingTrackingNumber = ResponseHelper::getString($data, 'tracking_number');
        $this->shippingTrackingUrl = ResponseHelper::getString($data, 'tracking_url');

        return $this;
    }

    protected function getFieldValidations(): array
    {
        return [
            'returnTrackingUrl' => Validation::TYPE_URL_OPTIONAL,
            'shippingTrackingUrl' => Validation::TYPE_URL_OPTIONAL,
        ];
    }

    protected function _toArray(): array
    {
        return [
            'return_shipping_company' => $this->returnShippingCompany,
            'return_tracking_number' => $this->returnTrackingNumber,
            'return_tracking_url' => $this->returnTrackingUrl,
            'shipping_company' => $this->shippingCompany,
            'shipping_method' => $this->shippingMethod,
            'tracking_number' => $this->shippingTrackingNumber,
            'tracking_url' => $this->shippingTrackingUrl,
        ];
    }
}
