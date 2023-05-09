<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Model;

use BadMethodCallException;
use Billie\Sdk\Exception\BillieException;
use Billie\Sdk\Exception\Validation\InvalidFieldException;
use Billie\Sdk\Exception\Validation\InvalidFieldValueCollectionException;
use Billie\Sdk\Exception\Validation\InvalidFieldValueException;
use Billie\Sdk\Util\Validation;
use ReflectionClass;

abstract class AbstractModel
{
    protected bool $readOnly = false;

    private bool $validateOnSet = true;

    private bool $_modelHasBeenValidated = false;

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

    /**
     * @internal use toArray
     */
    public function fromArray(array $data): self
    {
        return $this;
    }

    // we can not mark this as final, because we can not use the models for mocks in phpunit when it is final.
    public function toArray(): array
    {
        $this->validateFields();

        return $this->_toArray();
    }

    /**
     * @throws InvalidFieldValueCollectionException
     */
    public function validateFields(): void
    {
        if ($this->_modelHasBeenValidated) {
            // model values has not been changed and the last check was valid.
            return;
        }

        $errorCollection = new InvalidFieldValueCollectionException();
        foreach ($this->getObjectVars() as $field => $value) {
            try {
                $this->validateFieldValue($field, $value);
            } catch (InvalidFieldValueException $invalidFieldValueException) {
                $errorCollection->addError($field, $invalidFieldValueException);
            }
        }

        if ($errorCollection->getErrors() !== []) {
            throw $errorCollection;
        }

        $this->_modelHasBeenValidated = true;
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

    protected function getFieldValidations(): array
    {
        return [];
    }

    protected function _toArray(): array
    {
        return array_map(static function ($value) {
            if ($value instanceof self) {
                $value = $value->toArray();
            }

            return $value;
        }, $this->getObjectVars());
    }

    private function getObjectVars(): array
    {
        $vars = get_object_vars($this);

        // we add all not initialized fields to the list, because they will not return as null value.
        // we need these null values to validate the model.
        $ref = new ReflectionClass($this);
        foreach ($ref->getProperties() as $property) {
            if (!isset($this->{$property->getName()})) {
                $vars[$property->getName()] = null;
            }
        }

        unset($vars['readOnly']);
        unset($vars['validateOnSet']);
        unset($vars['_modelHasBeenValidated']);

        return $vars;
    }

    /**
     * @return mixed|null
     * @throws InvalidFieldException
     */
    private function get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name} ?? null;
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
            } else {
                $this->_modelHasBeenValidated = false;
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
        Validation::validatePropertyValue($this, $field, $value, $validations[$field] ?? null);
    }
}
