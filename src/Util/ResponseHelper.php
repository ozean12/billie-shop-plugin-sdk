<?php
/*
 * Copyright (c) Billie GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Billie\Sdk\Util;

use DateTime;
use DateTimeInterface;

class ResponseHelper
{
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

    public static function getArray(array $data, string $key): ?array
    {
        $value = self::getValue($data, $key);

        return is_array($value) ? $value : null;
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
}
