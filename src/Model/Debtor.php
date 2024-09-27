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
use Billie\Sdk\Model\Response\BankAccount;

/**
 * @method string getName()
 * @method Address getCompanyAddress()
 * @method Address|null getBillingAddress()
 * @method DebtorExternalData|null getExternalData()
 */
class Debtor extends AbstractResponseModel
{
    protected ?string $name; // may be null on declined orders

    protected ?Address $companyAddress; // may be null on declined orders

    protected ?Address $billingAddress;

    protected ?DebtorExternalData $externalData;

    protected ?BankAccount $bankAccount;
}
