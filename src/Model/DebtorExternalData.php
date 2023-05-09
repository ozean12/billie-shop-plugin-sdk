<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

use Billie\Sdk\Model\Response\AbstractResponseModel;
use Billie\Sdk\Util\ResponseHelper;

/**
 * @method string|null getMerchantCustomerId()
 * @method string|null getName()
 * @method string|null getIndustrySector()
 * @method Address|null getAddress()
 */
class DebtorExternalData extends AbstractResponseModel
{
    protected ?string $merchantCustomerId = null;

    protected ?string $name = null;

    protected ?string $industrySector = null;

    protected ?Address $address = null;

    public function fromArray(array $data): self
    {
        $this->merchantCustomerId = ResponseHelper::getString($data, 'merchant_customer_id');
        $this->name = ResponseHelper::getString($data, 'name');
        $this->industrySector = ResponseHelper::getString($data, 'industry_sector');
        $this->address = ResponseHelper::getObject($data, 'address', Address::class, true);

        return $this;
    }
}
