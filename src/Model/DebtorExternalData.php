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

/**
 * @method string|null getMerchantCustomerId()
 * @method string|null getName()
 * @method string|null getIndustrySector()
 * @method Address|null getAddress()
 */
class DebtorExternalData extends AbstractResponseModel
{
    protected ?string $merchantCustomerId;

    protected ?string $name;

    protected ?string $industrySector;

    protected ?Address $address;
}
