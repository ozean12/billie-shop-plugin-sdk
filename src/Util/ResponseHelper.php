<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Util;

use BadMethodCallException;
use Billie\Sdk\Exception\InvalidResponseException;
use DateTime;
use DateTimeInterface;

/**
 * @method static string getStringNN(array $data, string $key)
 * @method static int getIntNN(array $data, string $key)
 * @method static float getFloatNN(array $data, string $key)
 * @method static DateTime getDateTimeNN(array $data, string $key, string $format = DateTimeInterface::ATOM)
 * @method static DateTime getDateNN(array $data, string $key, string $format = 'Y-m-d')
 */
class ResponseHelper
{
    /**
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if (preg_match('/^(get(Object|String|DateTime|Date|Int|Float))NN$/', $name, $matches)) {
            return self::returnNotNull($matches[1], $arguments);
        }

        throw new BadMethodCallException('Method `' . $name . '` does not exists on `' . self::class . '`');
    }

    /**
     * @return mixed|null
     */
    public static function getValue(array $data, string $key)
    {
        return $data[$key] ?? null;
    }

    public static function getString(array $data, string $key): ?string
    {
        $value = self::getValue($data, $key);

        return is_string($value) ? $value : null;
    }

    public static function getInt(array $data, string $key): ?int
    {
        $value = self::getValue($data, $key);

        return is_numeric($value) ? (int) $value : null;
    }

    public static function getFloat(array $data, string $key): ?float
    {
        $value = self::getValue($data, $key);

        return is_numeric($value) ? (float) $value : null;
    }

    public static function getBoolean(array $data, string $key): ?bool
    {
        $value = self::getValue($data, $key);

        return (bool) $value;
    }

    public static function getArray(array $data, string $key, string $itemClass = null, bool $itemReadOnly = true): ?array
    {
        $value = self::getValue($data, $key);

        $values = is_array($value) ? $value : null;
        if ($values !== null && $itemClass !== null) {
            foreach ($values as $i => $e) {
                $values[$i] = new $itemClass($e, $itemReadOnly);
            }
        }

        return $values;
    }

    public static function getDateTime(array $data, string $key, string $format = DateTimeInterface::ATOM): ?DateTime
    {
        $value = self::getString($data, $key);
        $return = $value ? DateTime::createFromFormat($format, $value) : null;

        return $return ?: null;
    }

    public static function getDate(array $data, string $key, string $format = 'Y-m-d'): ?DateTime
    {
        return self::getDateTime($data, $key, $format);
    }

    /**
     * @template T
     * @param class-string<T> $class the class to instantiate
     * @return T|null
     */
    public static function getObject(array $data, string $key, string $class, bool $readOnly = true)
    {
        return isset($data[$key]) ? new $class($data[$key], $readOnly) : null;
    }

    /**
     * @template T
     * @param class-string<T> $class the class to instantiate
     * @return T
     */
    public static function getObjectNN(array $data, string $key, string $class, bool $readOnly = true)
    {
        return self::__callStatic('getObjectNN', func_get_args());
    }

    /**
     * @return mixed
     */
    private static function returnNotNull(string $method, array $arguments = [])
    {
        $value = self::$method(...$arguments);

        if ($value === null) {
            throw new InvalidResponseException(
                sprintf(
                    'Key `%s` was expected in response. key does not exist, or is null. Object: %s',
                    $arguments[1],
                    (string) json_encode($arguments[0])
                )
            );
        }

        return $value;
    }
}
