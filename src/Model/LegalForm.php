<?php

namespace Billie\Sdk\Model;

use Billie\Sdk\Util\ResponseHelper;

class LegalForm extends AbstractModel
{
    /**
     * @var string
     */
    private $code;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $requiredField;
    /**
     * @var bool
     */
    private $required;

    public function fromArray($data)
    {
        $this->code = ResponseHelper::getValue($data, 'code');
        $this->name = ResponseHelper::getValue($data, 'name');
        $this->requiredField = ResponseHelper::getValue($data, 'required_input');
        $this->required = ResponseHelper::getValue($data, 'required');

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRequiredField()
    {
        return $this->requiredField;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }
}
