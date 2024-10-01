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
use DateTime;
use DateTimeInterface;

/**
 * @method string   getUuid()
 * @method string   getNumber()
 * @method string   getState()
 * @method float    getPayoutAmount()
 * @method Amount   getAmount()
 * @method float    getOutstandingAmount()
 * @method float    getPendingMerchantPaymentAmount()
 * @method float    getPendingCancellationAmount()
 * @method float    getFeeAmount()
 * @method float    getFeeRate()
 * @method DateTime getDueDate()
 * @method DateTime getCreatedAt()
 */
class Invoice extends AbstractResponseModel
{
    protected ?string $uuid;

    protected ?string $number;

    protected ?string $state;

    protected ?float $payoutAmount;

    protected ?Amount $amount;

    protected ?float $outstandingAmount;

    protected ?float $pendingMerchantPaymentAmount;

    protected ?float $pendingCancellationAmount;

    protected ?float $feeAmount;

    protected ?float $feeRate;

    protected ?DateTimeInterface $dueDate;

    protected ?DateTimeInterface $createdAt;
}
