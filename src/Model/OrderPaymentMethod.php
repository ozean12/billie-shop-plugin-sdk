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
 * @method string getType()
 * @method string|null getIban()
 * @method string|null getBic()
 * @method string|null getBankName()
 * @method string|null getMandateReference()
 * @method DateTime|null getMandateExecutionDate()
 * @method string|null getCreditorIdentification()
 */
class OrderPaymentMethod extends AbstractResponseModel
{
    protected string $type;

    protected ?string $iban = null;

    protected ?string $bic = null;

    protected ?string $bankName = null;

    protected ?string $mandateReference = null;

    protected ?DateTimeInterface $mandateExecutionDate = null;

    protected ?string $creditorIdentification = null;

    public function fromArray(array $data): AbstractModel
    {
        if (isset($data['data'])) {
            $data = array_merge([
                'type' => $data['type'],
            ], $data['data']);
        }

        return parent::fromArray($data);
    }
}
