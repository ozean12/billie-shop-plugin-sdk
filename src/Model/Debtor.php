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
 * @method string getName()
 * @method Address getCompanyAddress()
 * @method Address|null getBillingAddress()
 * @method DebtorExternalData|null getExternalData()
 */
class Debtor extends AbstractResponseModel
{
    protected string $name;

    protected Address $companyAddress;

    protected ?Address $billingAddress = null;

    protected ?DebtorExternalData $externalData = null;

    public function fromArray(array $data): self
    {
        $this->name = ResponseHelper::getString($data, 'name') ?? ''; // may be null on declined orders
        $this->companyAddress = ResponseHelper::getObjectNN($data, 'company_address', Address::class, true, true);
        $this->billingAddress = ResponseHelper::getObject($data, 'billing_address', Address::class, true);
        $this->externalData = ResponseHelper::getObject($data, 'external_data', DebtorExternalData::class, true);

        return $this;
    }
}
