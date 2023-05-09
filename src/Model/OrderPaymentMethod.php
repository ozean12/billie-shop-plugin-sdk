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
use DateTime;

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

    protected ?DateTime $mandateExecutionDate = null;

    protected ?string $creditorIdentification = null;

    public function fromArray(array $data): self
    {
        $this->type = ResponseHelper::getStringNN($data, 'type');
        if (isset($data['data']) && is_array($data['data'])) {
            $data = $data['data'];
            $this->iban = ResponseHelper::getString($data, 'iban');
            $this->bic = ResponseHelper::getString($data, 'bic');
            $this->bankName = ResponseHelper::getString($data, 'bank_name');
            $this->mandateReference = ResponseHelper::getString($data, 'mandate_reference');
            $this->mandateExecutionDate = ResponseHelper::getDate($data, 'mandate_execution_date', 'Y-m-d H:i:s');
            $this->creditorIdentification = ResponseHelper::getString($data, 'creditor_identification');
        }

        return $this;
    }
}
