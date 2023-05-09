<?php

declare(strict_types=1);

namespace Billie\Sdk\Model;

use BadMethodCallException;
use Billie\Sdk\Exception\BillieException;
use Billie\Sdk\Exception\Validation\InvalidFieldException;
use Billie\Sdk\Exception\Validation\InvalidFieldValueCollectionException;
use Billie\Sdk\Exception\Validation\InvalidFieldValueException;

abstract class AbstractModel
{
    protected bool $readOnly = false;

    private bool $validateOnSet = true;

    public function __construct(array $data = [], bool $readOnly = false)
    {
        $this->readOnly = $readOnly;
        if ($data !== []) {
            $this->fromArray($data);
        }
    }

    /**
     * @return mixed|null
     */
    public function __call(string $name, ?array $arguments = [])
    {
        $field = lcfirst(substr($name, 3));

        if (strpos($name, 'set') === 0 && method_exists($this, 'set')) {
            return $this->set($field, $arguments[0] ?? null);
        }

        if (strpos($name, 'get') === 0 || strpos($name, 'is') === 0) {
            return $this->get($field);
        }

        throw new BadMethodCallException('Method `' . $name . '` does not exists on `' . self::class . '`');
    }

    public function fromArray(array $data): self
    {
        return $this;
    }

    public function toArray(): array
    {
        return array_map(static function ($value) {
            if ($value instanceof self) {
                $value = $value->toArray();
            }

            return $value;
        }, get_object_vars($this));
    }

    public function getFieldValidations(): array
    {
        return [];
    }

    /**
     * @throws InvalidFieldValueCollectionException
     */
    final public function validateFields(): void
    {
        $errorCollection = new InvalidFieldValueCollectionException();
        foreach (get_object_vars($this) as $field => $value) {
            try {
                $this->validateFieldValue($field, $value);
            } catch (InvalidFieldValueException $invalidFieldValueException) {
                $errorCollection->addError($field, $invalidFieldValueException);
            }
        }

        if ($errorCollection->getErrors() !== []) {
            throw $errorCollection;
        }
    }

    public function enableValidateOnSet(): self
    {
        return $this->setValidateOnSet(true);
    }

    public function disableValidateOnSet(): self
    {
        return $this->setValidateOnSet(false);
    }

    public function setValidateOnSet(bool $flag): self
    {
        $this->validateOnSet = $flag;

        return $this;
    }

    /**
     * @return mixed|null
     * @throws InvalidFieldException
     */
    private function get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        throw new InvalidFieldException($name, $this);
    }

    /**
     * @param mixed|null $value
     * @throws BillieException
     */
    private function set(string $name, $value): self
    {
        if ($this->readOnly) {
            throw new BadMethodCallException('the model `' . static::class . '` is read only');
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
     * @param mixed $value the value to validate
     * @throws InvalidFieldValueException
     */
    private function validateFieldValue(string $field, $value): void
    {
        $validations = $this->getFieldValidations();
        if (!isset($validations[$field])) {
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

            $typeErrorMessage = sprintf('The field %s of the model %s has an invalid value. Expected type: %s. Given type: %s', $field, static::class, $type, is_object($value) ? get_class($value) : gettype($value));

            $allowedFloatTypes = ['integer', 'double'];
            if (class_exists($type)) {
                if (!is_object($value) || !$value instanceof $type) {
                    throw new InvalidFieldValueException($typeErrorMessage);
                }

                if ($value instanceof self) {
                    $value->validateFields();
                }
            } elseif ($type === 'url') {
                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    throw new InvalidFieldValueException(sprintf('The field %s of the model %s has an invalid value. The value must be a url. Given value: %s', $field, static::class, is_object($value) ? get_class($value) : gettype($value)));
                }
            } elseif (gettype($value) !== $type && ($type !== 'float' || !in_array(gettype($value), $allowedFloatTypes, true))) {
                throw new InvalidFieldValueException($typeErrorMessage);
            }
        }
    }
}
