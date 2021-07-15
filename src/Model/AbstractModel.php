<?php

namespace Billie\Sdk\Model;

use BadMethodCallException;
use Billie\Sdk\Exception\BillieException;
use Billie\Sdk\Exception\Validation\InvalidFieldException;
use Billie\Sdk\Exception\Validation\InvalidFieldValueCollectionException;
use Billie\Sdk\Exception\Validation\InvalidFieldValueException;

abstract class AbstractModel
{
    /**
     * @var bool
     */
    protected $readOnly;

    /**
     * @var bool
     */
    private $validateOnSet = true;

    /**
     * AbstractModel constructor.
     *
     * @param array $data
     * @param bool  $readOnly
     */
    public function __construct($data = [], $readOnly = false)
    {
        $this->readOnly = $readOnly;
        if (count($data)) {
            $this->fromArray($data);
        }
    }

    /**
     * @param string $name
     */
    public function __call($name, $arguments)
    {
        $field = lcfirst(substr($name, 3));

        if (strpos($name, 'set') === 0 && method_exists($this, 'set')) {
            return call_user_func_array([$this, 'set'], array_merge([$field], $arguments));
        }
        if (strpos($name, 'get') === 0 || strpos($name, 'is') === 0) {
            return call_user_func_array([$this, 'get'], array_merge([$field], $arguments));
        }
        throw new BadMethodCallException('Method `' . $name . '` does not exists on `' . self::class . '`');
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function fromArray($data)
    {
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_map(static function ($value) {
            if ($value instanceof AbstractModel) {
                $value = $value->toArray();
            }

            return $value;
        }, get_object_vars($this));
    }

    /**
     * @return array
     */
    public function getFieldValidations()
    {
        return [];
    }

    /**
     * @throws InvalidFieldValueCollectionException
     *
     * @return void
     */
    final public function validateFields()
    {
        $errorCollection = new InvalidFieldValueCollectionException();
        foreach (get_object_vars($this) as $field => $value) {
            try {
                $this->validateFieldValue($field, $value);
            } catch (InvalidFieldValueException $e) {
                $errorCollection->addError($field, $e);
            }
        }
        if (count($errorCollection->getErrors())) {
            throw $errorCollection;
        }
    }

    /**
     * @return $this
     */
    public function enableValidateOnSet()
    {
        return $this->setValidateOnSet(true);
    }

    /**
     * @return $this
     */
    public function disableValidateOnSet()
    {
        return $this->setValidateOnSet(false);
    }

    /**
     * @param bool $flag
     *
     * @return $this
     */
    public function setValidateOnSet($flag)
    {
        $this->validateOnSet = $flag;

        return $this;
    }

    /**
     * @param string $name
     *
     * @throws InvalidFieldException
     *
     * @return mixed|null
     */
    private function get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
        throw new InvalidFieldException($name, $this);
    }

    /**
     * @param string $name
     *
     * @throws BillieException
     *
     * @return $this
     */
    private function set($name, $value)
    {
        if ($this->readOnly) {
            throw new \BadMethodCallException('the model `' . get_class($this) . '` is read only');
        }

        if (property_exists($this, $name)) {
            if ($this->validateOnSet) {
                $this->validateFieldValue($name, $value);
            }
            $this->{$name} = $value;

            return $this;
        }
        throw new InvalidFieldException($name, $this);
    }

    /**
     * @param string $field the field-name to validate
     * @param mixed  $value the value to validate
     *
     * @throws InvalidFieldValueException
     *
     * @return void
     */
    private function validateFieldValue($field, $value)
    {
        $validations = $this->getFieldValidations();
        if (isset($validations[$field]) === false) {
            return;
        }
        $type = $validations[$field];

        if (is_callable($type)) {
            $type = $type($this, $value);
        }

        if (is_string($type)) {
            if (strpos($type, '?') === 0) {
                $type = substr($type, 1);
                if ($value === null) {
                    return;
                }
            }
            $typeErrorMessage = sprintf('The field %s of the model %s has an invalid value. Expected type: %s. Given type: %s', $field, get_class($this), $type, is_object($value) ? get_class($value) : gettype($value));

            $allowedFloatTypes = ['integer', 'double'];
            if (class_exists($type)) {
                if (!is_object($value) || $value instanceof $type === false) {
                    throw new InvalidFieldValueException($typeErrorMessage);
                }
                if ($value instanceof AbstractModel) {
                    $value->validateFields();
                }
            } elseif ($type === 'url') {
                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    throw new InvalidFieldValueException(sprintf('The field %s of the model %s has an invalid value. The value must be a url. Given value: %s', $field, get_class($this), is_object($value) ? get_class($value) : gettype($value)));
                }
            } elseif (gettype($value) !== $type && ($type !== 'float' || !in_array(gettype($value), $allowedFloatTypes, true))) {
                throw new InvalidFieldValueException($typeErrorMessage);
            }
        }
    }
}
