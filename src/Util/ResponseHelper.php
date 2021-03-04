<?php

namespace Billie\Sdk\Util;

use Billie\Sdk\Model\AbstractModel;
use DateTime;

class ResponseHelper
{
    /**
     * @param array  $data the response-data
     * @param string $key  the key to get
     *
     * @return mixed|null
     */
    public static function getValue($data, $key)
    {
        return isset($data[$key]) ? $data[$key] : null;
    }

    /**
     * @param array  $data   the response-data
     * @param string $key    the key to get
     * @param string $format date format
     *
     * @return DateTime|null
     */
    public static function getDateTime($data, $key, $format = DateTime::ATOM)
    {
        $value = self::getValue($data, $key);
        $return = $value ? DateTime::createFromFormat($format, $value) : null;

        return $return ?: null;
    }

    /**
     * @param array  $data   the response-data
     * @param string $key    the key to get
     * @param string $format
     *
     * @return DateTime|null
     */
    public static function getDate($data, $key, $format = 'Y-m-d')
    {
        return self::getDateTime($data, $key, $format);
    }

    /**
     * @param array  $data     the response-data
     * @param string $key      the key to get
     * @param string $class    the class to instantiate
     * @param bool   $readOnly true if the model should be read only
     *
     * @return AbstractModel|null
     */
    public static function getObject($data, $key, $class, $readOnly = true)
    {
        return isset($data[$key]) ? new $class($data[$key], $readOnly) : null;
    }
}
