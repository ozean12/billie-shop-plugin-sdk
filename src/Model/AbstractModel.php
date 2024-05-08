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
use Billie\Sdk\Util\ResponseHelper;
use Billie\Sdk\Util\Validation;
use DateTimeInterface;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionType;

abstract class AbstractModel
{
    /**
     * maps the model-field to the gateway-field
     * @var array<string, string|false>
     */
    protected static array $_additionalFieldMapping = [];

    private bool $_readOnly = false;

    private bool $_validateOnSet = true;

    private bool $_modelHasBeenValidated = false;

    private bool $_validateOnToArray = true;

    public function __construct(array $data = [], bool $readOnly = false)
    {
        $this->_readOnly = $readOnly;
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

        throw new BadMethodCallException('Method `' . $name . '` does not exists on `' . static::class . '`');
    }

    /**
     * @return $this
     * @internal
     */
    public function fromArray(array $data): self
    {
        $customMappings = $this->prepareModelData($data);

        $ref = new ReflectionClass($this);
        foreach ($this->getPropertyNames() as $propertyName) {
            $dataKey = static::$_additionalFieldMapping[$propertyName] ?? $this->convertPropertyNameToSnakeCase($propertyName);

            if ($dataKey === false) {
                // field has been excluded
                continue;
            }

            /** @noinspection PhpUnhandledExceptionInspection */
            $property = $ref->getProperty($propertyName);
            $refType = $property->getType();
            if (!$refType instanceof ReflectionNamedType) {
                continue;
            }

            $isNullable = $refType->allowsNull();
            $type = $refType->getName();
            if (!is_callable($customMappings[$propertyName] ?? null)) {
                if (isset($customMappings[$propertyName])) {
                    $value = $customMappings[$propertyName];
                } elseif (class_exists($type) || interface_exists($type)) { // interface: date-time
                    // TODO implement little backdoor or unit-tests, that objects can be empty.
                    $value = ResponseHelper::getObject($data, $dataKey, $type, $this->_readOnly, false, $isNullable);
                } else {
                    switch ($type) {
                        case 'int':
                            $value = ResponseHelper::getInt($data, $dataKey, $isNullable);
                            break;
                        case 'float':
                            $value = ResponseHelper::getFloat($data, $dataKey, $isNullable);
                            break;
                        case 'bool':
                        case 'boolean':
                            $value = ResponseHelper::getBoolean($data, $dataKey);
                            break;
                        case 'string':
                            $value = ResponseHelper::getString($data, $dataKey, $isNullable);
                            break;
                        case 'array':
                            $value = ResponseHelper::getArray($data, $dataKey) ?? [];
                            break;
                    }
                }
            } else {
                $value = $customMappings[$propertyName]($dataKey);
            }

            if (!isset($value) && $isNullable) {
                $value = null;
            }

            if (isset($value)) {
                $this->{$propertyName} = $value;
                unset($value);
            }
        }

        return $this;
    }

    /**
     * @throws InvalidFieldValueCollectionException
     */
    public function toArray(bool $doValidate = true): array
    {
        // we can not mark this method as final, because we can not use the models for mocks in phpunit when it is final.
        $prevValidateState = $this->_validateOnToArray;
        if ($this->_validateOnToArray = $doValidate) {
            $this->validateFields();
        }

        $this->_validateOnToArray = $prevValidateState;

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

    /**
     * @return $this
     */
    public function enableValidateOnSet(): self
    {
        return $this->setValidateOnSet(true);
    }

    /**
     * @return $this
     */
    public function disableValidateOnSet(): self
    {
        return $this->setValidateOnSet(false);
    }

    /**
     * @return $this
     */
    public function setValidateOnSet(bool $flag): self
    {
        $this->_validateOnSet = $flag;

        return $this;
    }

    protected function prepareModelData(array $data): array
    {
        return [];
    }

    protected function getFieldValidations(): array
    {
        return [];
    }

    /**
     * @throws InvalidFieldValueCollectionException
     */
    protected function _toArray(): array
    {
        $preparedData = $this->prepareValuesForGateway($this->getObjectVars());

        $values = [];
        foreach ($preparedData as $key => $value) {
            if (!is_numeric($key)) { // for the case, if the request-array is a list of objects (instead of an object)
                $key = static::$_additionalFieldMapping[$key] ?? $key;
                /** @phpstan-ignore-next-line */
                if ($key === false) {
                    // field has been excluded
                    continue;
                }

                $key = $this->convertPropertyNameToSnakeCase($key);
            }

            $values[$key] = $this->convertObjectsRecursively($value);
        }

        return $values;
    }

    /**
     * @return array<string, mixed>
     */
    protected function prepareValuesForGateway(array $data): array
    {
        return $data;
    }

    /**
     * @param mixed $value
     * @return mixed
     * @throws InvalidFieldValueCollectionException
     */
    private function convertObjectsRecursively($value)
    {
        if ($value instanceof self) {
            return $value->toArray();
        } elseif ($value instanceof DateTimeInterface) {
            return $value->getTimestamp();
        } elseif (is_array($value)) {
            foreach ($value as $key => $_value) {
                $value[$key] = $this->convertObjectsRecursively($_value);
            }
        }

        return $value;
    }

    private function getPropertyNames(): array
    {
        $names = [];
        $refModel = new ReflectionClass($this);
        $refSelf = new ReflectionClass(self::class); // not $this/static::class!
        foreach ($refModel->getProperties(ReflectionProperty::IS_PROTECTED) as $property) {
            if (!$refSelf->hasProperty($property->getName())) {
                $names[] = $property->getName();
            }
        }

        // filter properties which seems to be they should not send to gateway
        return array_filter($names, static fn (string $key): bool => strpos($key, '_') !== 0);
    }

    private function getObjectVars(): array
    {
        $vars = [];
        foreach ($this->getPropertyNames() as $propertyName) {
            if (!(static::$_additionalFieldMapping[$propertyName] ?? true)) {
                // field has been excluded
                continue;
            }

            $vars[$propertyName] = $this->{$propertyName} ?? null;
        }

        return $vars;
    }

    private function convertPropertyNameToSnakeCase(string $string): string
    {
        return strtolower((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
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
        if ($this->_readOnly) {
            throw new BadMethodCallException('the model `' . static::class . '` is read only');
        }

        if (property_exists($this, $name)) {
            if ($this->_validateOnSet) {
                $this->validateFieldValue($name, $value);
            } else {
                $this->_modelHasBeenValidated = false;
            }

            // special case: if the property does not allow null, but the validation definition allows null, we will unset the property.
            $validations = $this->getFieldValidations();
            if (isset($validations[$name]) && $validations[$name] === Validation::IS_NOT_REQUIRED && $value === null) {
                $propertyType = (new ReflectionProperty($this, $name))->getType();
                if ($propertyType instanceof ReflectionType && !$propertyType->allowsNull()) {
                    unset($this->{$name});

                    return $this;
                }
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
