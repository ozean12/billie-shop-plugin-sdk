<?php

namespace Billie\Sdk\Model;

use Billie\Sdk\Model\Response\AbstractResponseModel;
use Billie\Sdk\Util\ResponseHelper;

/**
 * @method self   setIban(string $iban)
 * @method string getIban()
 * @method self   setBic(string $bic)
 * @method string getBic()
 */
class BankAccount extends AbstractResponseModel
{
    /** @var string */
    protected $iban;

    /** @var string */
    protected $bic;

    /**
     * {@inheritDoc}
     */
    public function fromArray($data)
    {
        $this->iban = ResponseHelper::getValue($data, 'iban');
        $this->bic = ResponseHelper::getValue($data, 'bic');

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return [
            'iban' => $this->iban,
            'bic' => $this->bic,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldValidations()
    {
        return [
            'iban' => 'string',
            'bic' => 'string',
        ];
    }
}
