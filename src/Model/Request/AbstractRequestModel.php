<?php


namespace Billie\Sdk\Model\Request;


use Billie\Sdk\Exception\BillieException;
use Billie\Sdk\Exception\Validation\InvalidFieldException;
use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Model\AbstractModel;

abstract class AbstractRequestModel extends AbstractModel
{

    /**
     * @return array
     */
    public function toArray()
    {
        return [];
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return self
     * @throws BillieException
     */
    protected function set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->validateFieldValue($name, $value);
            $this->{$name} = $value;
            return $this;
        }
        throw new InvalidFieldException($name, $this);
    }

    public function getFieldValidations()
    {
        return [];
    }

    private function validateFieldValue($field, $value)
    {
        $validations = $this->getFieldValidations();
        if (isset($validations[$field]) === false) {
            return;
        }
        $type = $validations[$field];
        switch ($type) {
            case 'string':
                if (is_string($value) === false) {
                    throw new InvalidFieldValueException($field, $this, $type);
                }
                break;
            case 'integer':
                if (is_int($value) === false) {
                    throw new InvalidFieldValueException($field, $this, $type);
                }
                break;
            default:
                if (class_exists($validations[$field]) && $value instanceof $validations[$field] === false) {
                    throw new InvalidFieldValueException($field, $this, $type);
                }
                throw new \RuntimeException('Type `' . $type . '` is unknown');
        }
    }

}